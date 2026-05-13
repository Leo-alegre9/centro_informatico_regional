<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use App\Models\ProductoImagenModel;

class Productos extends BaseController
{
    private ProductoModel       $model;
    private CategoriaModel      $catModel;
    private ProductoImagenModel $imgModel;

    public function __construct()
    {
        $this->model    = new ProductoModel();
        $this->catModel = new CategoriaModel();
        $this->imgModel = new ProductoImagenModel();
    }

    public function index()
    {
        $productos = $this->model->getAllForAdmin();
        $map       = $this->catModel->getCategoriaMap();

        foreach ($productos as &$p) {
            $p['categoria_path'] = $this->catModel->getPathForId((int) $p['categoria_id'], $map);
        }
        unset($p);

        return view('admin/productos/index', [
            'titulo'    => 'Gestión de Productos | CIR Admin',
            'productos' => $productos,
        ]);
    }

    public function crear()
    {
        return view('admin/productos/form', [
            'titulo'           => 'Nuevo producto | CIR Admin',
            'producto'         => null,
            'catPath'          => null,
            'accion'           => base_url('admin/productos/crear'),
            'jerarquia'        => $this->catModel->buildJerarquia(),
            'imagenesActuales' => [],
        ]);
    }

    public function guardar()
    {
        $rules = [
            'categoria_id' => 'required|is_natural_no_zero',
            'nombre'       => 'required|max_length[200]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nombre = $this->request->getPost('nombre');

        $id = $this->model->insert([
            'categoria_id'      => (int) $this->request->getPost('categoria_id'),
            'nombre'            => $nombre,
            'descripcion_corta' => $this->request->getPost('descripcion_corta') ?: null,
            'descripcion'       => $this->request->getPost('descripcion') ?: null,
            'precio_texto'      => $this->request->getPost('precio_texto') ?: 'Consultar precio',
            'badge'             => $this->request->getPost('badge') ?? '',
            'icono'             => 'fas fa-box',
            'activo'            => $this->request->getPost('activo') ? 1 : 0,
            'destacado'         => $this->request->getPost('destacado') ? 1 : 0,
            'orden'             => 0,
        ]);

        $esPrincipal = true;
        foreach ($this->getArchivosSubidos() as $archivo) {
            $this->subirImagen($archivo, (int) $id, $nombre, $esPrincipal);
            $esPrincipal = false;
        }

        return redirect()->to(base_url('admin/productos'))->with('success', 'Producto creado correctamente.');
    }

    public function editar(int $id)
    {
        $producto = $this->model->find($id);

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/productos/form', [
            'titulo'           => 'Editar producto | CIR Admin',
            'producto'         => $producto,
            'catPath'          => $this->catModel->getSlugPath((int) $producto['categoria_id']),
            'accion'           => base_url("admin/productos/{$id}/editar"),
            'jerarquia'        => $this->catModel->buildJerarquia(),
            'imagenesActuales' => $this->imgModel->getByProducto($id),
        ]);
    }

    public function actualizar(int $id)
    {
        $producto = $this->model->find($id);

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'categoria_id' => 'required|is_natural_no_zero',
            'nombre'       => 'required|max_length[200]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nombre = $this->request->getPost('nombre');

        $this->model->update($id, [
            'categoria_id'      => (int) $this->request->getPost('categoria_id'),
            'nombre'            => $nombre,
            'descripcion_corta' => $this->request->getPost('descripcion_corta') ?: null,
            'descripcion'       => $this->request->getPost('descripcion') ?: null,
            'precio_texto'      => $this->request->getPost('precio_texto') ?: 'Consultar precio',
            'badge'             => $this->request->getPost('badge') ?? '',
            'activo'            => $this->request->getPost('activo') ? 1 : 0,
            'destacado'         => $this->request->getPost('destacado') ? 1 : 0,
        ]);

        // Eliminar imágenes marcadas
        foreach ($this->request->getPost('eliminar_imagenes') ?? [] as $imgId) {
            $this->eliminarImagenPorId((int) $imgId);
        }

        // Cambiar imagen principal
        $principalId = (int) $this->request->getPost('imagen_principal_id');
        if ($principalId > 0) {
            $this->imgModel->where('producto_id', $id)->update(null, ['es_principal' => 0]);
            $this->imgModel->update($principalId, ['es_principal' => 1]);
        }

        // Subir nuevas imágenes
        $hayPrincipal = $principalId > 0
            || $this->imgModel->where('producto_id', $id)->where('es_principal', 1)->countAllResults() > 0;

        $esPrincipal = !$hayPrincipal;
        foreach ($this->getArchivosSubidos() as $archivo) {
            $this->subirImagen($archivo, $id, $nombre, $esPrincipal);
            $esPrincipal = false;
        }

        return redirect()->to(base_url('admin/productos'))->with('success', 'Producto actualizado correctamente.');
    }

    public function eliminar(int $id)
    {
        $producto = $this->model->find($id);

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->eliminarImagenPrincipal($id);
        $this->model->delete($id);

        return redirect()->to(base_url('admin/productos'))->with('success', 'Producto eliminado correctamente.');
    }

    public function toggleDestacado(int $id)
    {
        $producto = $this->model->find($id);

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $nuevoEstado = $producto['destacado'] ? 0 : 1;
        $this->model->update($id, ['destacado' => $nuevoEstado]);

        $msg = $nuevoEstado
            ? "«{$producto['nombre']}» ahora aparece en Productos Destacados."
            : "«{$producto['nombre']}» fue quitado de Productos Destacados.";

        return redirect()->to(base_url('admin/productos'))->with('success', $msg);
    }

    // ─── helpers privados ─────────────────────────────────────────────────────

    /** Devuelve los UploadedFile válidos del campo imagenes[]. */
    private function getArchivosSubidos(): array
    {
        $validos = [];
        $archivos = $this->request->getFiles()['imagenes'] ?? [];
        if (!is_array($archivos)) {
            $archivos = [$archivos];
        }
        foreach ($archivos as $archivo) {
            if ($archivo instanceof \CodeIgniter\HTTP\Files\UploadedFile
                && $archivo->isValid()
                && !$archivo->hasMoved()
                && $archivo->getSize() > 0
                && strpos($archivo->getClientMimeType(), 'image/') === 0
            ) {
                $validos[] = $archivo;
            }
        }
        return $validos;
    }

    private function subirImagen($file, int $productoId, string $altText, bool $esPrincipal = false): void
    {
        $uploadPath = FCPATH . 'assets/img/productos/';
        $newName    = 'producto_' . $productoId . '_' . time() . '_' . mt_rand(100, 999) . '.' . $file->getExtension();
        $file->move($uploadPath, $newName);

        $this->imgModel->insert([
            'producto_id'  => $productoId,
            'ruta'         => 'assets/img/productos/' . $newName,
            'alt_text'     => $altText,
            'es_principal' => $esPrincipal ? 1 : 0,
            'orden'        => 0,
        ]);
    }

    private function eliminarImagenPorId(int $imagenId): void
    {
        $img = $this->imgModel->find($imagenId);
        if ($img) {
            $filePath = FCPATH . $img['ruta'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $this->imgModel->delete($imagenId);
        }
    }

    private function eliminarImagenPrincipal(int $productoId): void
    {
        $imgActual = $this->imgModel->getPrincipal($productoId);
        if ($imgActual) {
            $this->eliminarImagenPorId($imgActual['id']);
        }
    }
}
