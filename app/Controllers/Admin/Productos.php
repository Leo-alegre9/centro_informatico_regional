<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use App\Models\ProductoImagenModel;
use App\Models\MarcaModel;
use App\Models\SeccionModel;
use App\Models\ProductoSeccionModel;
use App\Models\ConfiguracionModel;

class Productos extends BaseController
{
    private ProductoModel       $model;
    private CategoriaModel      $catModel;
    private ProductoImagenModel $imgModel;
    private MarcaModel          $marcaModel;
    private SeccionModel        $seccionModel;
    private ProductoSeccionModel $prodSeccionModel;

    public function __construct()
    {
        $this->model            = new ProductoModel();
        $this->catModel         = new CategoriaModel();
        $this->imgModel         = new ProductoImagenModel();
        $this->marcaModel       = new MarcaModel();
        $this->seccionModel     = new SeccionModel();
        $this->prodSeccionModel = new ProductoSeccionModel();
    }

    public function index()
    {
        $productos = $this->model->getAllForAdmin();
        $map       = $this->catModel->getCategoriaMap();
        $prodIds   = array_column($productos, 'id');
        $secMap    = $this->seccionModel->getSlugMapForProductos($prodIds);

        foreach ($productos as &$p) {
            $p['categoria_path'] = $this->catModel->getPathForId((int) $p['categoria_id'], $map);
            $p['secciones_slugs'] = $secMap[(int) $p['id']] ?? [];
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
            'titulo'            => 'Nuevo producto | CIR Admin',
            'producto'          => null,
            'catPath'           => null,
            'accion'            => base_url('admin/productos/crear'),
            'jerarquia'         => $this->catModel->buildJerarquia(),
            'imagenesActuales'  => [],
            'marcas'            => $this->marcaModel->where('activo', 1)->orderBy('nombre', 'ASC')->findAll(),
            'secciones'         => $this->getSeccionesFormulario(),
            'seccionesActivas'  => [],
        ]);
    }

    public function guardar()
    {
        $rules = [
            'categoria_id' => 'required|is_natural_no_zero',
            'nombre'       => 'required|max_length[200]',
            'codigo'       => 'permit_empty|max_length[100]|is_unique[productos.codigo]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nombre  = $this->request->getPost('nombre');
        $marcaId = (int) $this->request->getPost('marca_id');

        $seccionIds  = array_map('intval', (array) ($this->request->getPost('secciones') ?? []));
        $esDestacado = $this->seccionEsActiva('destacado', $seccionIds);

        $ubicacion = $this->request->getPost('ubicacion') ?: null;
        $codigo    = $this->request->getPost('codigo') ?: null;

        $precioDolar = $this->request->getPost('precio_dolar');
        $precioDolar = ($precioDolar !== '' && $precioDolar !== null) ? (float) $precioDolar : null;

        // Calcular precio en ARS si hay precio en USD y cotización configurada
        $precioTexto = $this->request->getPost('precio_texto') ?: null;
        if ($precioDolar !== null && $precioDolar > 0) {
            $precioTexto = $this->calcularPrecioARS($precioDolar) ?? $precioTexto;
        }

        $id = $this->model->insert([
            'categoria_id'      => (int) $this->request->getPost('categoria_id'),
            'marca_id'          => $marcaId > 0 ? $marcaId : null,
            'codigo'            => $codigo,
            'nombre'            => $nombre,
            'modelo'            => $this->request->getPost('modelo') ?: null,
            'descripcion_corta' => $this->request->getPost('descripcion_corta') ?: null,
            'descripcion'       => $this->request->getPost('descripcion') ?: null,
            'precio_texto'      => $precioTexto ?: 'Consultar precio',
            'precio_dolar'      => $precioDolar,
            'badge'             => $this->request->getPost('badge') ?? '',
            'icono'             => 'fas fa-box',
            'activo'            => $this->request->getPost('activo') ? 1 : 0,
            'destacado'         => $esDestacado ? 1 : 0,
            'orden'             => 0,
            'ubicacion'         => $ubicacion,
            'stock'             => max(0, (int) $this->request->getPost('stock')),
        ]);

        $this->prodSeccionModel->sincronizar((int) $id, $seccionIds);

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
            'titulo'            => 'Editar producto | CIR Admin',
            'producto'          => $producto,
            'catPath'           => $this->catModel->getSlugPath((int) $producto['categoria_id']),
            'accion'            => base_url("admin/productos/{$id}/editar"),
            'jerarquia'         => $this->catModel->buildJerarquia(),
            'imagenesActuales'  => $this->imgModel->getByProducto($id),
            'marcas'            => $this->marcaModel->where('activo', 1)->orderBy('nombre', 'ASC')->findAll(),
            'secciones'         => $this->getSeccionesFormulario(),
            'seccionesActivas'  => $this->prodSeccionModel->getSeccionIdsDeProducto($id),
        ]);
    }

    public function actualizar(int $id)
    {
        $producto = $this->model->find($id);

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $codigoActual = $producto['codigo'] ?? null;
        $codigoNuevo  = $this->request->getPost('codigo') ?: null;
        $unicidadRegla = 'permit_empty|max_length[100]';
        if ($codigoNuevo !== null && $codigoNuevo !== $codigoActual) {
            $unicidadRegla .= "|is_unique[productos.codigo,id,{$id}]";
        }

        $rules = [
            'categoria_id' => 'required|is_natural_no_zero',
            'nombre'       => 'required|max_length[200]',
            'codigo'       => $unicidadRegla,
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nombre      = $this->request->getPost('nombre');
        $marcaId     = (int) $this->request->getPost('marca_id');
        $seccionIds  = array_map('intval', (array) ($this->request->getPost('secciones') ?? []));
        $esDestacado = $this->seccionEsActiva('destacado', $seccionIds);

        $precioDolar = $this->request->getPost('precio_dolar');
        $precioDolar = ($precioDolar !== '' && $precioDolar !== null) ? (float) $precioDolar : null;

        $precioTexto = $this->request->getPost('precio_texto') ?: null;
        if ($precioDolar !== null && $precioDolar > 0) {
            $precioTexto = $this->calcularPrecioARS($precioDolar) ?? $precioTexto;
        }

        $this->model->update($id, [
            'categoria_id'      => (int) $this->request->getPost('categoria_id'),
            'marca_id'          => $marcaId > 0 ? $marcaId : null,
            'codigo'            => $codigoNuevo,
            'nombre'            => $nombre,
            'modelo'            => $this->request->getPost('modelo') ?: null,
            'descripcion_corta' => $this->request->getPost('descripcion_corta') ?: null,
            'descripcion'       => $this->request->getPost('descripcion') ?: null,
            'precio_texto'      => $precioTexto ?: 'Consultar precio',
            'precio_dolar'      => $precioDolar,
            'badge'             => $this->request->getPost('badge') ?? '',
            'activo'            => $this->request->getPost('activo') ? 1 : 0,
            'destacado'         => $esDestacado ? 1 : 0,
            'ubicacion'         => $this->request->getPost('ubicacion') ?: null,
            'stock'             => max(0, (int) $this->request->getPost('stock')),
        ]);

        $this->prodSeccionModel->sincronizar($id, $seccionIds);

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

        // Mantener sección "destacado" sincronizada con el campo
        $secDestacado = $this->seccionModel->where('slug', 'destacado')->first();
        if ($secDestacado) {
            if ($nuevoEstado) {
                // Agregar si no existe
                $existe = $this->prodSeccionModel
                    ->where('producto_id', $id)
                    ->where('seccion_id', $secDestacado['id'])
                    ->first();
                if (!$existe) {
                    $this->prodSeccionModel->insert([
                        'producto_id' => $id,
                        'seccion_id'  => (int) $secDestacado['id'],
                        'activo'      => 1,
                        'orden'       => 0,
                    ]);
                }
            } else {
                $this->prodSeccionModel
                    ->where('producto_id', $id)
                    ->where('seccion_id', $secDestacado['id'])
                    ->delete();
            }
        }

        $msg = $nuevoEstado
            ? "«{$producto['nombre']}» ahora aparece en el carrusel de productos destacados."
            : "«{$producto['nombre']}» fue quitado del carrusel de productos destacados.";

        return redirect()->to(base_url('admin/productos'))->with('success', $msg);
    }

    public function buscar()
    {
        $q    = trim($this->request->getGet('q') ?? '');
        $tipo = $this->request->getGet('tipo') ?? 'todos';

        $resultados = [];
        if ($q !== '') {
            $resultados = $this->model->buscarAdmin($q, $tipo);
            $map = $this->catModel->getCategoriaMap();
            foreach ($resultados as &$p) {
                $p['categoria_path'] = $this->catModel->getPathForId((int) $p['categoria_id'], $map);
            }
            unset($p);
        }

        return view('admin/productos/buscar', [
            'titulo'     => 'Buscar Producto | CIR Admin',
            'resultados' => $resultados,
            'q'          => $q,
            'tipo'       => $tipo,
        ]);
    }

    // ─── helpers privados ─────────────────────────────────────────────────────

    private function calcularPrecioARS(float $precioDolar): ?string
    {
        $config     = new ConfiguracionModel();
        $cotizacion = (float) $config->get('cotizacion_dolar', 0);
        $porcentaje = (float) $config->get('porcentaje_ganancia', 0);

        if ($cotizacion <= 0) {
            return null;
        }

        $precio = $precioDolar * $cotizacion * (1 + $porcentaje / 100);
        return '$' . number_format(round($precio), 0, ',', '.');
    }

    /**
     * Devuelve solo las 4 secciones visibles en el formulario de productos.
     * Las secciones 'destacado' y 'carrusel_promo' se gestionan internamente.
     */
    private function getSeccionesFormulario(): array
    {
        return $this->seccionModel
            ->whereIn('slug', ['inicio', 'catalogo', 'rubro', 'subrubro'])
            ->where('activo', 1)
            ->orderBy('orden', 'ASC')
            ->findAll();
    }

    /**
     * Verifica si una sección de slug dado está entre los IDs seleccionados.
     * Evita hacer una query extra si no hay IDs.
     */
    private function seccionEsActiva(string $slug, array $seccionIds): bool
    {
        if (empty($seccionIds)) {
            return false;
        }
        $sec = $this->seccionModel->where('slug', $slug)->first();
        return $sec && in_array((int) $sec['id'], $seccionIds, true);
    }

    private function getArchivosSubidos(): array
    {
        $validos  = [];
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
