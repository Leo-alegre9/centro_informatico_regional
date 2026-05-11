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
            'titulo'       => 'Nuevo producto | CIR Admin',
            'producto'     => null,
            'catPath'      => null,
            'accion'       => base_url('admin/productos/crear'),
            'jerarquia'    => $this->catModel->buildJerarquia(),
            'imagenActual' => null,
        ]);
    }

    public function guardar()
    {
        $rules = [
            'categoria_id' => 'required|is_natural_no_zero',
            'nombre'       => 'required|max_length[200]',
        ];

        $file = $this->request->getFile('imagen');
        if ($file && $file->isValid()) {
            $rules['imagen'] = 'max_size[imagen,3072]|is_image[imagen]|mime_in[imagen,image/jpeg,image/png,image/webp,image/gif]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->model->insert([
            'categoria_id'      => (int) $this->request->getPost('categoria_id'),
            'nombre'            => $this->request->getPost('nombre'),
            'descripcion_corta' => $this->request->getPost('descripcion_corta') ?: null,
            'descripcion'       => $this->request->getPost('descripcion') ?: null,
            'precio_texto'      => $this->request->getPost('precio_texto') ?: 'Consultar precio',
            'badge'             => $this->request->getPost('badge') ?? '',
            'icono'             => 'fas fa-box',
            'activo'            => $this->request->getPost('activo') ? 1 : 0,
            'orden'             => 0,
        ]);

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $this->subirImagen($file, (int) $id, $this->request->getPost('nombre'));
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
            'titulo'       => 'Editar producto | CIR Admin',
            'producto'     => $producto,
            'catPath'      => $this->catModel->getSlugPath((int) $producto['categoria_id']),
            'accion'       => base_url("admin/productos/{$id}/editar"),
            'jerarquia'    => $this->catModel->buildJerarquia(),
            'imagenActual' => $this->imgModel->getPrincipal($id),
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

        $file = $this->request->getFile('imagen');
        if ($file && $file->isValid()) {
            $rules['imagen'] = 'max_size[imagen,3072]|is_image[imagen]|mime_in[imagen,image/jpeg,image/png,image/webp,image/gif]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'categoria_id'      => (int) $this->request->getPost('categoria_id'),
            'nombre'            => $this->request->getPost('nombre'),
            'descripcion_corta' => $this->request->getPost('descripcion_corta') ?: null,
            'descripcion'       => $this->request->getPost('descripcion') ?: null,
            'precio_texto'      => $this->request->getPost('precio_texto') ?: 'Consultar precio',
            'badge'             => $this->request->getPost('badge') ?? '',
            'activo'            => $this->request->getPost('activo') ? 1 : 0,
        ]);

        // Eliminar imagen si se solicitó
        if ($this->request->getPost('eliminar_imagen')) {
            $this->eliminarImagenPrincipal($id);
        }

        // Subir nueva imagen (reemplaza la actual si existe)
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $this->eliminarImagenPrincipal($id);
            $this->subirImagen($file, $id, $this->request->getPost('nombre'));
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

    // ─── helpers privados ─────────────────────────────────────────────────────

    private function subirImagen($file, int $productoId, string $altText): void
    {
        $uploadPath = FCPATH . 'assets/img/productos/';
        $newName    = 'producto_' . $productoId . '_' . time() . '.' . $file->getExtension();
        $file->move($uploadPath, $newName);

        $this->imgModel->insert([
            'producto_id'  => $productoId,
            'ruta'         => 'assets/img/productos/' . $newName,
            'alt_text'     => $altText,
            'es_principal' => 1,
            'orden'        => 0,
        ]);
    }

    private function eliminarImagenPrincipal(int $productoId): void
    {
        $imgActual = $this->imgModel->getPrincipal($productoId);
        if ($imgActual) {
            $filePath = FCPATH . $imgActual['ruta'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $this->imgModel->delete($imgActual['id']);
        }
    }
}
