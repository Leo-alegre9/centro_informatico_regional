<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use App\Models\ProductoImagenModel;
use App\Models\MarcaModel;
use App\Models\FabricaModel;
use App\Models\LineaModel;
use App\Models\SeccionModel;
use App\Models\ProductoSeccionModel;
use App\Models\ConfiguracionModel;
use App\Models\ColorVarianteModel;
use App\Models\ColorImagenModel;
use App\Models\CaracteristicaModel;

class Productos extends BaseController
{
    private ProductoModel       $model;
    private CategoriaModel      $catModel;
    private ProductoImagenModel $imgModel;
    private MarcaModel          $marcaModel;
    private FabricaModel        $fabricaModel;
    private LineaModel          $lineaModel;
    private SeccionModel        $seccionModel;
    private ProductoSeccionModel $prodSeccionModel;
    private ColorVarianteModel  $varianteModel;
    private ColorImagenModel    $imagenColorModel;
    private CaracteristicaModel $caractModel;

    public function __construct()
    {
        $this->model            = new ProductoModel();
        $this->catModel         = new CategoriaModel();
        $this->imgModel         = new ProductoImagenModel();
        $this->marcaModel       = new MarcaModel();
        $this->fabricaModel     = new FabricaModel();
        $this->lineaModel       = new LineaModel();
        $this->seccionModel     = new SeccionModel();
        $this->prodSeccionModel = new ProductoSeccionModel();
        $this->varianteModel    = new ColorVarianteModel();
        $this->imagenColorModel = new ColorImagenModel();
        $this->caractModel      = new CaracteristicaModel();
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
            'titulo'                 => 'Nuevo producto | CIR Admin',
            'producto'               => null,
            'catPath'                => null,
            'accion'                 => base_url('admin/productos/crear'),
            'jerarquia'              => $this->catModel->buildJerarquia(),
            'imagenesActuales'       => [],
            'marcas'                 => $this->marcaModel->where('activo', 1)->orderBy('nombre', 'ASC')->findAll(),
            'fabricas'               => $this->fabricaModel->getActivas(),
            'lineasPorFabrica'       => $this->lineaModel->getMapaActivasPorFabrica(),
            'secciones'              => $this->getSeccionesFormulario(),
            'seccionesActivas'       => [],
            'variantesColor'         => [],
            'caracteristicasActuales' => [],
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

        $categoriaId = (int) $this->request->getPost('categoria_id');
        $fabricaId   = (int) $this->request->getPost('fabrica_id');

        if ($errorFabrica = $this->validarFabricaRequerida($categoriaId, $fabricaId)) {
            return redirect()->back()->withInput()->with('errors', [$errorFabrica]);
        }

        $variantes = $this->parsearVariantesColor(0);
        if ($variantes['error']) {
            return redirect()->back()->withInput()->with('errors', [$variantes['error']]);
        }

        $nombre  = $this->request->getPost('nombre');
        $marcaId = (int) $this->request->getPost('marca_id');

        $seccionIds  = array_map('intval', (array) ($this->request->getPost('secciones') ?? []));
        $esDestacado = $this->seccionEsActiva('destacado', $seccionIds);

        $ubicacion = $this->request->getPost('ubicacion') ?: null;
        $codigo    = $this->request->getPost('codigo') ?: null;

        $precioDolar = $this->request->getPost('precio_dolar');
        $precioDolar = ($precioDolar !== '' && $precioDolar !== null) ? (float) $precioDolar : null;

        $precioInterno = $this->request->getPost('precio_interno');
        $precioInterno = ($precioInterno !== '' && $precioInterno !== null) ? (float) $precioInterno : null;

        // Calcular precio en ARS si hay precio en USD y cotización configurada
        $precioTexto = $this->request->getPost('precio_texto') ?: null;
        if ($precioDolar !== null && $precioDolar > 0) {
            $precioTexto = $this->calcularPrecioARS($precioDolar) ?? $precioTexto;
        }

        $slug = trim((string) $this->request->getPost('slug'));
        $slug = $this->model->generarSlugUnico($slug !== '' ? $slug : $nombre);

        $id = $this->model->insert([
            'categoria_id'      => $categoriaId,
            'marca_id'          => $marcaId > 0 ? $marcaId : null,
            'fabrica_id'        => $fabricaId > 0 ? $fabricaId : null,
            'linea_id'          => $this->resolverLineaId($fabricaId, (int) $this->request->getPost('linea_id')),
            'codigo'            => $codigo,
            'nombre'            => $nombre,
            'slug'              => $slug,
            'modelo'            => $this->request->getPost('modelo') ?: null,
            'descripcion_corta' => $this->request->getPost('descripcion_corta') ?: null,
            'descripcion'       => $this->request->getPost('descripcion') ?: null,
            'url_fabricante'    => $this->request->getPost('url_fabricante') ?: null,
            'precio_texto'      => $precioTexto ?: 'Consultar precio',
            'precio_numero'     => $this->extraerPrecioNumerico($precioTexto),
            'precio_dolar'      => $precioDolar,
            'precio_interno'    => $precioInterno,
            'badge'             => $this->request->getPost('badge') ?? '',
            'icono'             => 'fas fa-box',
            'activo'            => $this->request->getPost('activo') ? 1 : 0,
            'destacado'         => $esDestacado ? 1 : 0,
            'orden'             => 0,
            'ubicacion'         => $ubicacion,
            'stock'             => max(0, (int) $this->request->getPost('stock')),
            'ancho'             => $this->request->getPost('ancho') ?: null,
            'alto'              => $this->request->getPost('alto') ?: null,
            'profundidad'       => $this->request->getPost('profundidad') ?: null,
            'unidad_medida'     => $this->request->getPost('unidad_medida') ?: 'cm',
            'material'          => $this->request->getPost('material') ?: null,
        ]);

        $this->prodSeccionModel->sincronizar((int) $id, $seccionIds);
        $this->aplicarVariantesColor((int) $id, $variantes['filas']);
        $this->caractModel->sincronizarProducto((int) $id, $this->parseCaracteristicas($this->request->getPost('caracteristicas') ?? []));

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

        $variantesColor = $this->varianteModel->getByProducto($id);
        foreach ($variantesColor as &$v) {
            $v['galeria'] = $this->imagenColorModel->getByColor((int) $v['id']);
        }
        unset($v);

        return view('admin/productos/form', [
            'titulo'                 => 'Editar producto | CIR Admin',
            'producto'               => $producto,
            'catPath'                => $this->catModel->getSlugPath((int) $producto['categoria_id']),
            'accion'                 => base_url("admin/productos/{$id}/editar"),
            'jerarquia'              => $this->catModel->buildJerarquia(),
            'imagenesActuales'       => $this->imgModel->getByProducto($id),
            'marcas'                 => $this->marcaModel->where('activo', 1)->orderBy('nombre', 'ASC')->findAll(),
            'fabricas'               => $this->fabricaModel->getActivas(),
            'lineasPorFabrica'       => $this->lineaModel->getMapaActivasPorFabrica(),
            'secciones'              => $this->getSeccionesFormulario(),
            'seccionesActivas'       => $this->prodSeccionModel->getSeccionIdsDeProducto($id),
            'variantesColor'         => $variantesColor,
            'caracteristicasActuales' => $this->caractModel->getByProducto($id),
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

        $categoriaId = (int) $this->request->getPost('categoria_id');
        $fabricaId   = (int) $this->request->getPost('fabrica_id');

        if ($errorFabrica = $this->validarFabricaRequerida($categoriaId, $fabricaId)) {
            return redirect()->back()->withInput()->with('errors', [$errorFabrica]);
        }

        $variantes = $this->parsearVariantesColor($id);
        if ($variantes['error']) {
            return redirect()->back()->withInput()->with('errors', [$variantes['error']]);
        }

        $nombre      = $this->request->getPost('nombre');
        $marcaId     = (int) $this->request->getPost('marca_id');
        $seccionIds  = array_map('intval', (array) ($this->request->getPost('secciones') ?? []));
        $esDestacado = $this->seccionEsActiva('destacado', $seccionIds);

        $precioDolar = $this->request->getPost('precio_dolar');
        $precioDolar = ($precioDolar !== '' && $precioDolar !== null) ? (float) $precioDolar : null;

        $precioInterno = $this->request->getPost('precio_interno');
        $precioInterno = ($precioInterno !== '' && $precioInterno !== null) ? (float) $precioInterno : null;

        $precioTexto = $this->request->getPost('precio_texto') ?: null;
        if ($precioDolar !== null && $precioDolar > 0) {
            $precioTexto = $this->calcularPrecioARS($precioDolar) ?? $precioTexto;
        }

        $slugNuevo = trim((string) $this->request->getPost('slug'));
        $slug      = $this->model->generarSlugUnico($slugNuevo !== '' ? $slugNuevo : $nombre, $id);

        $this->model->update($id, [
            'categoria_id'      => $categoriaId,
            'marca_id'          => $marcaId > 0 ? $marcaId : null,
            'fabrica_id'        => $fabricaId > 0 ? $fabricaId : null,
            'linea_id'          => $this->resolverLineaId($fabricaId, (int) $this->request->getPost('linea_id')),
            'codigo'            => $codigoNuevo,
            'nombre'            => $nombre,
            'slug'              => $slug,
            'modelo'            => $this->request->getPost('modelo') ?: null,
            'descripcion_corta' => $this->request->getPost('descripcion_corta') ?: null,
            'descripcion'       => $this->request->getPost('descripcion') ?: null,
            'url_fabricante'    => $this->request->getPost('url_fabricante') ?: null,
            'precio_texto'      => $precioTexto ?: 'Consultar precio',
            'precio_numero'     => $this->extraerPrecioNumerico($precioTexto),
            'precio_dolar'      => $precioDolar,
            'precio_interno'    => $precioInterno,
            'badge'             => $this->request->getPost('badge') ?? '',
            'activo'            => $this->request->getPost('activo') ? 1 : 0,
            'destacado'         => $esDestacado ? 1 : 0,
            'ubicacion'         => $this->request->getPost('ubicacion') ?: null,
            'stock'             => max(0, (int) $this->request->getPost('stock')),
            'ancho'             => $this->request->getPost('ancho') ?: null,
            'alto'              => $this->request->getPost('alto') ?: null,
            'profundidad'       => $this->request->getPost('profundidad') ?: null,
            'unidad_medida'     => $this->request->getPost('unidad_medida') ?: 'cm',
            'material'          => $this->request->getPost('material') ?: null,
        ]);

        $this->prodSeccionModel->sincronizar($id, $seccionIds);
        $this->aplicarVariantesColor($id, $variantes['filas']);
        $this->caractModel->sincronizarProducto($id, $this->parseCaracteristicas($this->request->getPost('caracteristicas') ?? []));

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

    public function toggleActivo(int $id)
    {
        $producto = $this->model->find($id);

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $nuevoEstado = $producto['activo'] ? 0 : 1;
        $this->model->update($id, ['activo' => $nuevoEstado]);

        $msg = $nuevoEstado
            ? "«{$producto['nombre']}» ahora está activo y visible en el sitio."
            : "«{$producto['nombre']}» fue desactivado y ya no se muestra en el sitio.";

        return redirect()->to(base_url('admin/productos'))->with('success', $msg);
    }

    public function ver(int $id)
    {
        $producto = $this->model->getByIdConDetalle($id);

        if (!$producto) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $variantesColor = $this->varianteModel->getByProducto($id);
        foreach ($variantesColor as &$v) {
            $v['estilo']  = ColorVarianteModel::estiloSwatch($v);
            $v['galeria'] = $this->imagenColorModel->getByColor((int) $v['id']);
        }
        unset($v);

        $nombres = $this->catModel->nombresRubroSubrubro((int) $producto['categoria_id'], $this->catModel->getCategoriaMap());

        return view('admin/productos/ver', [
            'titulo'            => 'Ver: ' . $producto['nombre'] . ' | CIR Admin',
            'producto'          => $producto,
            'rubroNombre'       => $nombres['rubro'],
            'subrubroNombre'    => $nombres['subrubro'],
            'imagenesGenerales' => $this->imgModel->getByProducto($id),
            'variantesColor'    => $variantesColor,
            'caracteristicas'   => $this->caractModel->getByProducto($id),
        ]);
    }

    public function buscar()
    {
        $q         = trim((string) $this->request->getGet('q'));
        $tipo      = $this->request->getGet('tipo') ?? 'todos';
        $rubroSlug = trim((string) $this->request->getGet('rubro'));
        $subSlug   = trim((string) $this->request->getGet('subrubro'));
        $marcaId   = (int) $this->request->getGet('marca');
        $fabricaId = (int) $this->request->getGet('fabrica');
        $lineaId   = (int) $this->request->getGet('linea');
        $estado    = $this->request->getGet('estado') ?? '';
        $stock     = $this->request->getGet('stock') ?? '';

        $hayFiltros = $q !== '' || $rubroSlug !== '' || $marcaId > 0 || $fabricaId > 0 || $lineaId > 0 || $estado !== '' || $stock !== '';

        $resultados   = [];
        $pager        = null;
        $categoriaIds = [];
        $rubroCat     = null;
        $subrubrosDelRubro = [];

        if ($rubroSlug !== '') {
            $rubroCat = $this->catModel->findBySlugPath($rubroSlug);
            if ($rubroCat) {
                $subrubrosDelRubro = $this->catModel->getChildren((int) $rubroCat['id']);
                if ($subSlug !== '') {
                    $subCat       = $this->catModel->findBySlugPath($rubroSlug, $subSlug);
                    $categoriaIds = $subCat ? $this->catModel->getDescendantIds((int) $subCat['id']) : [];
                } else {
                    $categoriaIds = $this->catModel->getDescendantIds((int) $rubroCat['id']);
                }
            }
        }

        if ($hayFiltros) {
            $filtros = [
                'q'             => $q,
                'tipo'          => $tipo,
                'categoria_ids' => $categoriaIds,
                'marca_id'      => $marcaId,
                'fabrica_id'    => $fabricaId,
                'linea_id'      => $lineaId,
                'activo'        => $estado,
                'stock'         => $stock,
            ];

            $resultado  = $this->model->buscarProductosAdmin($filtros, 30);
            $resultados = $resultado['resultados'];
            $pager      = $resultado['pager'];

            $map = $this->catModel->getCategoriaMap();
            foreach ($resultados as &$p) {
                $p['categoria_path'] = $this->catModel->getPathForId((int) $p['categoria_id'], $map);
                $nombres              = $this->catModel->nombresRubroSubrubro((int) $p['categoria_id'], $map);
                $p['rubro_nombre']    = $nombres['rubro'];
                $p['subrubro_nombre'] = $nombres['subrubro'];
            }
            unset($p);
        }

        $opciones = $this->model->obtenerOpcionesFiltros(['categoria_ids' => $categoriaIds, 'fabrica_id' => $fabricaId], false);

        $paramsActuales = array_filter([
            'q'        => $q,
            'tipo'     => $tipo !== 'todos' ? $tipo : '',
            'rubro'    => $rubroSlug,
            'subrubro' => $subSlug,
            'marca'    => $marcaId ?: '',
            'fabrica'  => $fabricaId ?: '',
            'linea'    => $lineaId ?: '',
            'estado'   => $estado,
            'stock'    => $stock,
        ], fn($v) => $v !== '' && $v !== 0);

        return view('admin/productos/buscar', [
            'titulo'            => 'Buscar Producto | CIR Admin',
            'resultados'        => $resultados,
            'total'             => $pager ? $pager->getTotal('admin_productos') : 0,
            'paginaActual'      => $pager ? $pager->getCurrentPage('admin_productos') : 1,
            'totalPaginas'      => $pager ? $pager->getPageCount('admin_productos') : 1,
            'baseParams'        => $paramsActuales,
            'q'                 => $q,
            'tipo'              => $tipo,
            'filtros'           => [
                'rubro' => $rubroSlug, 'subrubro' => $subSlug, 'marca' => $marcaId ?: '',
                'fabrica' => $fabricaId ?: '', 'linea' => $lineaId ?: '', 'estado' => $estado, 'stock' => $stock,
            ],
            'rubros'            => $this->catModel->getRubros(),
            'subrubrosOpciones' => $subrubrosDelRubro,
            'marcasOpciones'    => $opciones['marcas'],
            'fabricasOpciones'  => $opciones['fabricas'],
            'lineasOpciones'    => $opciones['lineas'],
        ]);
    }

    // ─── helpers privados ─────────────────────────────────────────────────────

    /**
     * Los productos del rubro "Muebles" requieren seleccionar una fábrica.
     * Devuelve el mensaje de error si falta, o null si la validación pasa.
     */
    private function validarFabricaRequerida(int $categoriaId, int $fabricaId): ?string
    {
        if ($fabricaId > 0) {
            return null;
        }

        $rubro = $this->catModel->getSlugPath($categoriaId)['rubro'] ?? '';
        if ($rubro !== 'muebles') {
            return null;
        }

        return 'Seleccioná la fábrica del mueble.';
    }

    /** Solo persiste la línea si pertenece a la fábrica seleccionada; si no, la ignora (es opcional). */
    private function resolverLineaId(int $fabricaId, int $lineaId): ?int
    {
        if ($fabricaId <= 0 || $lineaId <= 0) {
            return null;
        }

        $linea = $this->lineaModel->find($lineaId);
        if (!$linea || (int) $linea['fabrica_id'] !== $fabricaId) {
            return null;
        }

        return $lineaId;
    }

    /**
     * Extrae el valor numérico de un precio_texto en formato argentino ($12.345,67 o $12.345)
     * para poblar precio_numero, usado por el filtro de ordenamiento por precio del catálogo.
     * Devuelve null si el texto no contiene un número (p. ej. "Consultar precio").
     */
    private function extraerPrecioNumerico(?string $texto): ?float
    {
        if (!$texto || !preg_match('/([0-9]{1,3}(?:\.[0-9]{3})*|[0-9]+)(,[0-9]+)?/', $texto, $m)) {
            return null;
        }

        $entero  = str_replace('.', '', $m[1]);
        $decimal = isset($m[2]) ? str_replace(',', '.', $m[2]) : '';
        $valor   = $entero . $decimal;

        return is_numeric($valor) ? (float) $valor : null;
    }

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
            ->whereIn('slug', ['inicio', 'catalogo', 'rubro', 'subrubro', 'carrusel_promo'])
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

    /**
     * Parsea y valida las variantes de color enviadas como variantes[idx][campo].
     * No escribe nada en base de datos ni mueve archivos: solo valida y arma las filas
     * a persistir, para poder rechazar el guardado completo del producto si hay un error.
     *
     * @return array{error: ?string, filas: array}
     */
    private function parsearVariantesColor(int $productoId): array
    {
        $post  = $this->request->getPost('variantes') ?? [];
        $files = $this->request->getFiles()['variantes'] ?? [];

        if (!is_array($post)) {
            return ['error' => null, 'filas' => []];
        }

        $filas = [];
        foreach ($post as $idx => $datos) {
            if (!is_array($datos)) {
                continue;
            }

            $nombre = trim((string) ($datos['nombre'] ?? ''));
            $tipo   = in_array($datos['tipo'] ?? '', ['simple', 'combinado', 'textura'], true)
                ? $datos['tipo']
                : 'simple';

            $archivo       = is_array($files[$idx] ?? null) ? ($files[$idx]['imagen'] ?? null) : null;
            $archivoValido = null;
            if ($archivo instanceof \CodeIgniter\HTTP\Files\UploadedFile
                && $archivo->isValid() && !$archivo->hasMoved() && $archivo->getSize() > 0
            ) {
                $mimeOk = strpos($archivo->getClientMimeType(), 'image/') === 0;
                $extOk  = in_array(strtolower($archivo->getExtension()), ['jpg', 'jpeg', 'png', 'webp'], true);
                $sizeOk = $archivo->getSize() <= 3 * 1024 * 1024;
                if (!$mimeOk || !$extOk || !$sizeOk) {
                    return ['error' => 'La imagen de la variante de color debe ser JPG, PNG o WebP de hasta 3 MB.', 'filas' => []];
                }
                $archivoValido = $archivo;
            }

            $idExistente  = !empty($datos['id']) ? (int) $datos['id'] : null;
            $imagenActual = null;
            if ($idExistente && $productoId > 0) {
                $existente = $this->varianteModel->find($idExistente);
                if ($existente && (int) $existente['producto_id'] === $productoId) {
                    $imagenActual = $existente['imagen_muestra'];
                } else {
                    $idExistente = null;
                }
            } else {
                $idExistente = null;
            }

            $quitarImagen = !empty($datos['quitar_imagen']);

            // Fila sobrante sin completar (agregada y dejada vacía): se ignora en silencio.
            if ($nombre === '' && !$idExistente && !$archivoValido) {
                continue;
            }

            $galeria = $this->parsearGaleriaColor($idExistente, $datos, is_array($files[$idx] ?? null) ? $files[$idx] : []);
            if ($galeria['error']) {
                return ['error' => "Galería de «" . ($nombre !== '' ? $nombre : 'color sin nombre') . "»: {$galeria['error']}", 'filas' => []];
            }

            if ($nombre === '') {
                return ['error' => 'Cada color/variante necesita un nombre.', 'filas' => []];
            }

            $colorPrimario   = $this->normalizarHexColor($datos['color_primario'] ?? null);
            $colorSecundario = $this->normalizarHexColor($datos['color_secundario'] ?? null);

            if ($tipo !== 'textura' && $colorPrimario === null) {
                return ['error' => "El color primario es obligatorio para la variante «{$nombre}».", 'filas' => []];
            }
            if ($tipo === 'combinado' && $colorSecundario === null) {
                return ['error' => "El color secundario es obligatorio para la variante «{$nombre}» (combinación de dos colores).", 'filas' => []];
            }
            if ($tipo === 'textura' && !$archivoValido && ($quitarImagen || !$imagenActual)) {
                return ['error' => "La imagen es obligatoria para la variante «{$nombre}» (tipo textura).", 'filas' => []];
            }

            $filas[] = [
                'id'               => $idExistente,
                'nombre'           => $nombre,
                'tipo'             => $tipo,
                'color_primario'   => $tipo === 'textura' ? null : $colorPrimario,
                'color_secundario' => $tipo === 'combinado' ? $colorSecundario : null,
                'orden'            => (int) ($datos['orden'] ?? 0),
                'activo'           => !empty($datos['activo']) ? 1 : 0,
                'archivo'          => $archivoValido,
                'imagen_actual'    => $imagenActual,
                'quitar_imagen'    => $quitarImagen,
                'galeria'          => $galeria['datos'],
            ];
        }

        return ['error' => null, 'filas' => $filas];
    }

    /**
     * Parsea y valida la galería de imágenes propia de una variante de color:
     * qué imágenes existentes se conservan (y en qué orden), cuál es la principal,
     * su texto alternativo, y los archivos nuevos a subir. No escribe nada todavía.
     *
     * @return array{error: ?string, datos: array}
     */
    private function parsearGaleriaColor(?int $varianteId, array $datos, array $filesVariante): array
    {
        $existentesDb   = $varianteId ? $this->imagenColorModel->getByColor($varianteId) : [];
        $existentesIds  = array_map('intval', array_column($existentesDb, 'id'));

        $enviadosIds = array_map('intval', (array) ($datos['galeria_existente'] ?? []));
        $mantenidos  = array_values(array_intersect($enviadosIds, $existentesIds));

        $principalRaw = !empty($datos['galeria_principal']) ? (int) $datos['galeria_principal'] : null;
        $principal    = ($principalRaw !== null && in_array($principalRaw, $existentesIds, true)) ? $principalRaw : null;

        $altsExistentes = [];
        foreach ((array) ($datos['galeria_alt'] ?? []) as $imgId => $alt) {
            $altsExistentes[(int) $imgId] = trim((string) $alt);
        }

        $archivosNuevos = is_array($filesVariante['galeria_nueva'] ?? null) ? $filesVariante['galeria_nueva'] : [];
        $altsNuevos     = (array) ($datos['galeria_nueva_alt'] ?? []);

        $nuevas = [];
        foreach ($archivosNuevos as $gi => $archivo) {
            if (!$archivo instanceof \CodeIgniter\HTTP\Files\UploadedFile
                || !$archivo->isValid() || $archivo->hasMoved() || $archivo->getSize() <= 0
            ) {
                continue;
            }

            $mimeOk = strpos($archivo->getClientMimeType(), 'image/') === 0;
            $extOk  = in_array(strtolower($archivo->getExtension()), ['jpg', 'jpeg', 'png', 'webp'], true);
            $sizeOk = $archivo->getSize() <= 3 * 1024 * 1024;
            if (!$mimeOk || !$extOk || !$sizeOk) {
                return ['error' => 'las imágenes deben ser JPG, PNG o WebP de hasta 3 MB.', 'datos' => []];
            }

            $nuevas[] = ['archivo' => $archivo, 'alt' => trim((string) ($altsNuevos[$gi] ?? ''))];
        }

        return [
            'error' => null,
            'datos' => [
                'existentes'      => $mantenidos,
                'principal'       => $principal,
                'alt_existentes'  => $altsExistentes,
                'nuevas'          => $nuevas,
            ],
        ];
    }

    /**
     * Persiste las variantes de color ya validadas por parsearVariantesColor():
     * borra las que el admin quitó (junto con su imagen), y crea/actualiza el resto.
     * Las escrituras en base de datos van dentro de una transacción.
     */
    private function aplicarVariantesColor(int $productoId, array $filas): void
    {
        $idsEnviados  = array_filter(array_column($filas, 'id'));
        $existentesDb = $this->varianteModel->getByProducto($productoId);
        $idsAEliminar = array_diff(array_column($existentesDb, 'id'), $idsEnviados);

        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($idsAEliminar as $idEliminar) {
            $fila = $this->varianteModel->find($idEliminar);

            foreach ($this->imagenColorModel->getByColor($idEliminar) as $img) {
                $this->borrarArchivoImagenVariante($img['imagen']);
            }
            $this->varianteModel->delete($idEliminar); // CASCADE borra las filas de producto_color_imagenes

            if ($fila && !empty($fila['imagen_muestra'])) {
                $this->borrarArchivoImagenVariante($fila['imagen_muestra']);
            }
        }

        foreach ($filas as $fila) {
            $rutaImagen = $fila['imagen_actual'];

            if ($fila['archivo']) {
                if ($rutaImagen) {
                    $this->borrarArchivoImagenVariante($rutaImagen);
                }
                $rutaImagen = $this->subirImagenVariante($fila['archivo'], $productoId);
            } elseif ($fila['quitar_imagen'] && $rutaImagen) {
                $this->borrarArchivoImagenVariante($rutaImagen);
                $rutaImagen = null;
            }

            $data = [
                'producto_id'      => $productoId,
                'nombre'           => $fila['nombre'],
                'tipo'             => $fila['tipo'],
                'color_primario'   => $fila['color_primario'],
                'color_secundario' => $fila['color_secundario'],
                'imagen_muestra'   => $rutaImagen,
                'orden'            => $fila['orden'],
                'activo'           => $fila['activo'],
            ];

            if ($fila['id']) {
                $this->varianteModel->update($fila['id'], $data);
                $varianteId = $fila['id'];
            } else {
                $varianteId = (int) $this->varianteModel->insert($data);
            }

            $this->sincronizarGaleriaColor($varianteId, $fila['galeria']);
        }

        $db->transComplete();
    }

    /**
     * Persiste la galería de un color ya validada por parsearGaleriaColor(): borra las
     * imágenes que ya no vienen en el submit (junto a su archivo), reordena y marca
     * principal las que se conservan, sube las nuevas, y garantiza que siempre quede
     * una imagen principal (la primera por orden) si el color tiene al menos una imagen.
     */
    private function sincronizarGaleriaColor(int $varianteId, array $galeria): void
    {
        $existentesDb = $this->imagenColorModel->getByColor($varianteId);
        $mantenidos   = $galeria['existentes'];

        foreach ($existentesDb as $img) {
            if (!in_array((int) $img['id'], $mantenidos, true)) {
                $this->borrarArchivoImagenVariante($img['imagen']);
                $this->imagenColorModel->delete($img['id']);
            }
        }

        $orden         = 0;
        $huboPrincipal = false;
        foreach ($mantenidos as $imgId) {
            $esPrincipal = $galeria['principal'] === $imgId;
            if ($esPrincipal) {
                $huboPrincipal = true;
            }
            $this->imagenColorModel->update($imgId, [
                'orden'             => $orden,
                'es_principal'      => $esPrincipal ? 1 : 0,
                'texto_alternativo' => $galeria['alt_existentes'][$imgId] ?? null,
            ]);
            $orden++;
        }

        foreach ($galeria['nuevas'] as $nueva) {
            $ruta = $this->subirImagenGaleriaColor($nueva['archivo'], $varianteId);
            $this->imagenColorModel->insert([
                'producto_color_id' => $varianteId,
                'imagen'            => $ruta,
                'texto_alternativo' => $nueva['alt'] !== '' ? $nueva['alt'] : null,
                'es_principal'      => 0,
                'orden'             => $orden,
                'activo'            => 1,
            ]);
            $orden++;
        }

        if (!$huboPrincipal) {
            $primera = $this->imagenColorModel->getByColor($varianteId)[0] ?? null;
            if ($primera) {
                $this->imagenColorModel->update($primera['id'], ['es_principal' => 1]);
            }
        }
    }

    private function subirImagenGaleriaColor($file, int $varianteId): string
    {
        $uploadPath = FCPATH . 'assets/img/productos/';
        $newName    = 'color_galeria_' . $varianteId . '_' . time() . '_' . mt_rand(100, 999) . '.' . $file->getExtension();
        $file->move($uploadPath, $newName);

        return 'assets/img/productos/' . $newName;
    }

    /** Valida que sea un color hexadecimal de 6 dígitos (el que emite <input type="color">); null si no. */
    private function normalizarHexColor(?string $hex): ?string
    {
        $hex = trim((string) $hex);
        if ($hex === '') {
            return null;
        }
        return preg_match('/^#[0-9a-fA-F]{6}$/', $hex) ? strtolower($hex) : null;
    }

    private function subirImagenVariante($file, int $productoId): string
    {
        $uploadPath = FCPATH . 'assets/img/productos/';
        $newName    = 'color_producto_' . $productoId . '_' . time() . '_' . mt_rand(100, 999) . '.' . $file->getExtension();
        $file->move($uploadPath, $newName);

        return 'assets/img/productos/' . $newName;
    }

    private function borrarArchivoImagenVariante(string $ruta): void
    {
        $filePath = FCPATH . $ruta;
        if (is_file($filePath)) {
            unlink($filePath);
        }
    }

    /** Convierte los arrays paralelos caracteristicas[clave][]/[valor][] en filas ['clave'=>,'valor'=>]. */
    private function parseCaracteristicas(array $post): array
    {
        $claves = $post['clave'] ?? [];
        $valores = $post['valor'] ?? [];
        $filas = [];
        foreach ($claves as $i => $clave) {
            $filas[] = ['clave' => $clave, 'valor' => $valores[$i] ?? ''];
        }
        return $filas;
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
