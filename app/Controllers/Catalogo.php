<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\CategoriaModel;
use App\Models\ProductoModel;
use App\Models\ProductoImagenModel;

class Catalogo extends BaseController
{
    private CategoriaModel  $catModel;
    private ProductoModel   $productoModel;

    public function __construct()
    {
        $this->catModel      = new CategoriaModel();
        $this->productoModel = new ProductoModel();
    }

    // ── Índice del catálogo (/catalogo) ──────────────────────────────────────

    public function index(): string
    {
        $rubroMap        = $this->mapRubros($this->catModel->getRubros());
        $productosSeccion = $this->productoModel->getBySeccion('catalogo');

        // Todos los productos activos, filtrables del lado del cliente por rubro/subrubro/marca/fábrica/línea.
        $productosGrid = $this->mapearProductosGrid($this->productoModel->getFiltrablesPorCategorias());

        return view('catalogo_rubro', [
            'titulo'           => 'Catálogo | Centro Informático Regional',
            'breadcrumb'       => [
                ['nombre' => 'Inicio',   'url' => base_url()],
                ['nombre' => 'Catálogo', 'url' => null],
            ],
            'current'          => [
                'nombre'      => 'Catálogo',
                'icono'       => 'fas fa-th-large',
                'descripcion' => 'Explorá todos nuestros rubros y encontrá lo que necesitás.',
                'subrubros'   => $rubroMap,
            ],
            'currentPath'      => 'catalogo',
            'siblings'         => [],
            'allRubros'        => $rubroMap,
            'destacados'       => [],
            'productosSeccion' => $productosSeccion,
            'tituloSeccion'    => 'Selección del catálogo',
            'productosGrid'    => $productosGrid,
            'tituloGrid'       => 'Todos los productos',
            'subtituloGrid'    => 'Catálogo completo',
        ]);
    }

    // ── Navegación por slug path ──────────────────────────────────────────────

    public function browse(string $a, string $b = '', string $c = ''): string
    {
        $segments = array_values(array_filter([$a, $b, $c], fn($s) => $s !== ''));
        $nSeg     = count($segments);

        // 1. Buscar la categoría actual en la BD
        $dbCat = $this->catModel->findBySlugPath(
            $segments[0],
            $nSeg >= 2 ? $segments[1] : null,
            $nSeg >= 3 ? $segments[2] : null
        );

        if (!$dbCat) {
            throw PageNotFoundException::forPageNotFound();
        }

        // 2. Breadcrumb
        $breadcrumb = [
            ['nombre' => 'Inicio',   'url' => base_url()],
            ['nombre' => 'Catálogo', 'url' => base_url('catalogo')],
        ];

        if ($nSeg >= 2) {
            $cat1 = $this->catModel->findBySlugPath($segments[0]);
            if ($cat1) {
                $breadcrumb[] = [
                    'nombre' => $cat1['nombre'],
                    'url'    => base_url('catalogo/' . $segments[0]),
                ];
            }
        }

        if ($nSeg >= 3) {
            $cat2 = $this->catModel->findBySlugPath($segments[0], $segments[1]);
            if ($cat2) {
                $breadcrumb[] = [
                    'nombre' => $cat2['nombre'],
                    'url'    => base_url('catalogo/' . $segments[0] . '/' . $segments[1]),
                ];
            }
        }

        $breadcrumb[] = ['nombre' => $dbCat['nombre'], 'url' => null];

        $currentPath = 'catalogo/' . implode('/', $segments);

        // 3. Construir nodo actual
        $current = [
            'id'          => (int) $dbCat['id'],
            'nombre'      => $dbCat['nombre'],
            'icono'       => $dbCat['icono'] ?: 'fas fa-folder',
            'descripcion' => $dbCat['descripcion'] ?? '',
        ];

        // 4. Hijos de la categoría actual
        $children = $this->catModel->getChildren((int) $dbCat['id']);

        $descIds          = $this->catModel->getDescendantIds((int) $dbCat['id']);
        $productosSeccion = [];
        $tituloSeccion    = '';
        $productosGrid    = [];
        $tituloGrid       = 'Productos disponibles';
        $subtituloGrid    = 'Disponible en local';

        if (!empty($children)) {
            // Tiene hijos → mostrar grilla de subrubros
            $current['subrubros'] = $this->buildSubrubros($children);

            // Destacados del rubro: productos de sección "rubro" en descendientes
            $todosIds         = array_merge([(int) $dbCat['id']], $descIds);
            $productosSeccion = $this->productoModel->getPorSeccionEnDescendientes($todosIds, 'rubro', 12);
            $tituloSeccion    = 'Destacados en ' . $dbCat['nombre'];

            // Todos los productos activos del rubro (todas sus subrubros), filtrables por subrubro/marca/fábrica/línea.
            $productosGrid = $this->mapearProductosGrid($this->productoModel->getFiltrablesPorCategorias($todosIds));
            $tituloGrid    = 'Todos los productos de ' . $dbCat['nombre'];
            $subtituloGrid = 'Filtrá por subrubro, marca, fábrica o línea';
        } else {
            // Hoja → todos los productos activos de esta categoría (activo=1 es el control principal)
            $imgModel    = new ProductoImagenModel();
            $dbProductos = $this->productoModel->getByCategoriaId((int) $dbCat['id']);
            $imgsByProd  = [];

            if (!empty($dbProductos)) {
                $prodIds   = array_column($dbProductos, 'id');
                $todasImgs = $imgModel
                    ->whereIn('producto_id', $prodIds)
                    ->orderBy('es_principal', 'DESC')
                    ->orderBy('orden', 'ASC')
                    ->findAll();
                foreach ($todasImgs as $img) {
                    $imgsByProd[$img['producto_id']][] = $img;
                }
            }

            // Rubro/subrubro de esta categoría hoja: constantes para todos los productos listados.
            $nombresCat = $this->catModel->nombresRubroSubrubro((int) $dbCat['id'], $this->catModel->getCategoriaMap());

            $current['productos'] = array_map(function ($p) use ($imgsByProd, $nombresCat) {
                return [
                    'id'               => $p['id'],
                    'slug'             => $p['slug'] ?? '',
                    'codigo'           => $p['codigo'] ?? '',
                    'nombre'           => $p['nombre'],
                    'descripcion'      => $p['descripcion_corta'] ?? '',
                    'descripcion_full' => $p['descripcion'] ?? $p['descripcion_corta'] ?? '',
                    'precio'           => $p['precio_texto'],
                    'precio_num'       => $p['precio_numero'] ?? null,
                    'badge'            => $p['badge'],
                    'icono'            => $p['icono'],
                    'marca'            => $p['marca_nombre'] ?? '',
                    'fabrica'          => $p['fabrica_nombre'] ?? '',
                    'linea'            => $p['linea_nombre'] ?? '',
                    'rubro'            => $nombresCat['rubro'],
                    'subrubro'         => $nombresCat['subrubro'],
                    'imagen_url'       => !empty($imgsByProd[$p['id']]) ? $imgsByProd[$p['id']][0]['ruta'] : null,
                    'imagenes'         => $imgsByProd[$p['id']] ?? [],
                ];
            }, $dbProductos);

            $productosGrid = $current['productos'];

            // Destacados del subrubro: productos de sección "subrubro" para mostrar en área especial
            $productosSeccion = $this->productoModel->getPorSeccionEnDescendientes(
                [(int) $dbCat['id']],
                'subrubro',
                8
            );
            $tituloSeccion = 'Productos destacados en ' . $dbCat['nombre'];
        }

        // 5. Hermanos (chips de navegación en el header)
        $siblings = $this->buildSiblings($dbCat, $segments);

        // 6. Carrusel de destacados (campo destacado=1, independiente de secciones)
        $destacados = $this->productoModel->getDestacadosByCatIds($descIds, 8);

        // 7. Índice de rubros
        $allRubros = $this->mapRubros($this->catModel->getRubros());

        return view('catalogo_rubro', [
            'titulo'           => $dbCat['nombre'] . ' | Centro Informático Regional',
            'breadcrumb'       => $breadcrumb,
            'current'          => $current,
            'currentPath'      => $currentPath,
            'siblings'         => $siblings,
            'allRubros'        => $allRubros,
            'destacados'       => $destacados,
            'productosSeccion' => $productosSeccion,
            'tituloSeccion'    => $tituloSeccion,
            'productosGrid'    => $productosGrid,
            'tituloGrid'       => $tituloGrid,
            'subtituloGrid'    => $subtituloGrid,
        ]);
    }

    // ── Búsqueda (/catalogo/buscar) ──────────────────────────────────────────

    public function buscar()
    {
        $q      = trim((string) $this->request->getGet('q'));
        $rubro  = trim((string) $this->request->getGet('rubro'));
        $sub    = trim((string) $this->request->getGet('sub'));
        $subSub = trim((string) $this->request->getGet('subsub'));

        // ── Petición AJAX: mantener comportamiento JSON ──
        if ($this->request->isAJAX()) {
            if ($q === '') {
                return $this->response->setJSON(['resultados' => [], 'total' => 0]);
            }

            if ($rubro !== '') {
                $dbCat = $this->catModel->findBySlugPath(
                    $rubro,
                    $sub !== '' ? $sub : null,
                    $subSub !== '' ? $subSub : null
                );
                if (!$dbCat) {
                    return $this->response->setJSON(['resultados' => [], 'total' => 0]);
                }
                $catIds = $this->catModel->getDescendantIds((int) $dbCat['id']);
                if (empty($catIds)) {
                    $catIds = [(int) $dbCat['id']];
                }
            } else {
                $catIds = [];
            }

            $resultados = $this->productoModel->buscarEnCategoria($catIds, $q);

            $out = array_map(fn($p) => [
                'id'          => $p['id'],
                'slug'        => $p['slug'] ?? '',
                'codigo'      => $p['codigo'] ?? '',
                'nombre'      => $p['nombre'],
                'modelo'      => $p['modelo'] ?? '',
                'precio'      => $p['precio_texto'],
                'badge'       => $p['badge'],
                'imagen_url'  => $p['imagen_ruta'] ?? null,
                'icono'       => $p['icono'] ?? 'fas fa-box',
                'descripcion' => $p['descripcion_corta'] ?? $p['descripcion'] ?? '',
                'marca'       => $p['marca_nombre'] ?? '',
                'fabrica'     => $p['fabrica_nombre'] ?? '',
                'linea'       => $p['linea_nombre'] ?? '',
                'categoria'   => $p['categoria_nombre'] ?? '',
            ], $resultados);

            return $this->response->setJSON(['resultados' => $out, 'total' => count($out)]);
        }

        // ── Petición normal (página de resultados con filtros combinables) ──
        $marcaId   = (int) $this->request->getGet('marca');
        $fabricaId = (int) $this->request->getGet('fabrica');
        $lineaId   = (int) $this->request->getGet('linea');
        $orden     = trim((string) $this->request->getGet('orden'));

        // Acepta tanto rubro/subrubro (filtros de esta página) como rubro/sub/subsub
        // (compatibilidad con el buscador rápido del header, que usa esos nombres).
        $subrubro = trim((string) $this->request->getGet('subrubro'));
        if ($subrubro === '') {
            $subrubro = $sub;
        }

        $sinFiltros = $q === '' && $rubro === '' && $marcaId === 0 && $fabricaId === 0 && $lineaId === 0;
        if ($sinFiltros) {
            return redirect()->to(base_url('catalogo'));
        }

        $rubroCat    = null;
        $subrubroCat = null;
        $categoriaIds = [];

        if ($rubro !== '') {
            $rubroCat = $this->catModel->findBySlugPath($rubro);
            if ($rubroCat) {
                if ($subrubro !== '') {
                    $subrubroCat = $this->catModel->findBySlugPath($rubro, $subrubro);
                    $categoriaIds = $subrubroCat ? $this->catModel->getDescendantIds((int) $subrubroCat['id']) : [];
                } else {
                    $categoriaIds = $this->catModel->getDescendantIds((int) $rubroCat['id']);
                }
            }
        }

        $filtros = [
            'q'             => $q,
            'categoria_ids' => $categoriaIds,
            'marca_id'      => $marcaId,
            'fabrica_id'    => $fabricaId,
            'linea_id'      => $lineaId,
            'orden'         => $orden,
        ];

        $resultado    = $this->productoModel->buscarProductos($filtros, 24);
        $productosRaw = $resultado['resultados'];
        $pager        = $resultado['pager'];

        $productos = array_map(function ($p) {
            return [
                'id'           => $p['id'],
                'codigo'       => $p['codigo'] ?? '',
                'nombre'       => $p['nombre'],
                'modelo'       => $p['modelo'] ?? '',
                'precio'       => $p['precio_texto'],
                'badge'        => $p['badge'],
                'imagen_url'   => $p['imagen_ruta'] ?? null,
                'icono'        => $p['icono'] ?? 'fas fa-box',
                'descripcion'  => $p['descripcion_corta'] ?? '',
                'marca'        => $p['marca_nombre'] ?? '',
                'fabrica'      => $p['fabrica_nombre'] ?? '',
                'linea'        => $p['linea_nombre'] ?? '',
                'categoria'    => $p['categoria_nombre'] ?? '',
                'url_producto' => base_url('producto/' . ($p['slug'] ?: $p['id'])),
            ];
        }, $productosRaw);

        // Opciones de filtro dependientes: solo marcas/fábricas/líneas con productos en el contexto elegido.
        $opciones          = $this->productoModel->obtenerOpcionesFiltros(['categoria_ids' => $categoriaIds, 'fabrica_id' => $fabricaId]);
        $subrubrosOpciones = $rubroCat ? $this->catModel->getChildren((int) $rubroCat['id']) : [];

        // Filtros activos como chips removibles: cada uno arma la URL sin ese parámetro.
        $paramsActuales = array_filter([
            'q'        => $q,
            'rubro'    => $rubro,
            'subrubro' => $subrubro,
            'marca'    => $marcaId ?: '',
            'fabrica'  => $fabricaId ?: '',
            'linea'    => $lineaId ?: '',
            'orden'    => $orden,
        ], fn($v) => $v !== '' && $v !== 0);

        $chips = [];
        if ($q !== '') {
            $chips[] = ['label' => '"' . $q . '"', 'quitar' => $this->quitarParam($paramsActuales, 'q')];
        }
        if ($rubroCat) {
            $chips[] = ['label' => $rubroCat['nombre'], 'quitar' => $this->quitarParam($paramsActuales, ['rubro', 'subrubro'])];
        }
        if ($subrubroCat) {
            $chips[] = ['label' => $subrubroCat['nombre'], 'quitar' => $this->quitarParam($paramsActuales, 'subrubro')];
        }
        if ($marcaId > 0) {
            $marcaNombre = array_values(array_filter($opciones['marcas'], fn($m) => (int) $m['id'] === $marcaId))[0]['nombre'] ?? null;
            $chips[] = ['label' => $marcaNombre ?? 'Marca', 'quitar' => $this->quitarParam($paramsActuales, 'marca')];
        }
        if ($fabricaId > 0) {
            $fabricaNombre = array_values(array_filter($opciones['fabricas'], fn($f) => (int) $f['id'] === $fabricaId))[0]['nombre'] ?? null;
            $chips[] = ['label' => $fabricaNombre ?? 'Fábrica', 'quitar' => $this->quitarParam($paramsActuales, 'fabrica')];
        }
        if ($lineaId > 0) {
            $lineaNombre = array_values(array_filter($opciones['lineas'], fn($l) => (int) $l['id'] === $lineaId))[0]['nombre'] ?? null;
            $chips[] = ['label' => $lineaNombre ?? 'Línea', 'quitar' => $this->quitarParam($paramsActuales, 'linea')];
        }

        return view('catalogo_buscar', [
            'titulo'            => ($q !== '' ? 'Resultados para "' . esc($q) . '"' : 'Resultados de búsqueda') . ' | Centro Informático Regional',
            'query'             => $q,
            'productos'         => $productos,
            'total'             => $pager->getTotal('catalogo'),
            'paginaActual'      => $pager->getCurrentPage('catalogo'),
            'totalPaginas'      => $pager->getPageCount('catalogo'),
            'baseParams'        => $paramsActuales,
            'filtros'           => [
                'rubro' => $rubro, 'subrubro' => $subrubro, 'marca' => $marcaId ?: '',
                'fabrica' => $fabricaId ?: '', 'linea' => $lineaId ?: '', 'orden' => $orden,
            ],
            'rubros'            => $this->catModel->getRubros(),
            'subrubrosOpciones' => $subrubrosOpciones,
            'marcasOpciones'    => $opciones['marcas'],
            'fabricasOpciones'  => $opciones['fabricas'],
            'lineasOpciones'    => $opciones['lineas'],
            'chips'             => $chips,
        ]);
    }

    /** Devuelve $params sin la(s) clave(s) indicadas, para armar el link "quitar filtro" de un chip. */
    private function quitarParam(array $params, $claves): array
    {
        foreach ((array) $claves as $clave) {
            unset($params[$clave]);
        }
        return $params;
    }

    // ── Helpers privados ───────────────────────────────────────────────────────

    /**
     * Convierte filas de productos (con joins de marca/fábrica/línea/categoría ya
     * resueltos) al formato que espera la grilla filtrable del catálogo, agregando
     * el rubro/subrubro de cada uno. Se usa tanto para el catálogo general como
     * para las páginas de rubro con subrubros, para no duplicar el mapeo.
     */
    private function mapearProductosGrid(array $rows): array
    {
        if (empty($rows)) {
            return [];
        }

        $map = $this->catModel->getCategoriaMap();

        return array_map(function ($p) use ($map) {
            $nombres = $this->catModel->nombresRubroSubrubro((int) $p['categoria_id'], $map);

            return [
                'id'          => $p['id'],
                'slug'        => $p['slug'] ?? '',
                'codigo'      => $p['codigo'] ?? '',
                'nombre'      => $p['nombre'],
                'descripcion' => $p['descripcion_corta'] ?? '',
                'precio'      => $p['precio_texto'],
                'precio_num'  => $p['precio_numero'] ?? null,
                'badge'       => $p['badge'],
                'icono'       => $p['icono'],
                'marca'       => $p['marca_nombre'] ?? '',
                'fabrica'     => $p['fabrica_nombre'] ?? '',
                'linea'       => $p['linea_nombre'] ?? '',
                'rubro'       => $nombres['rubro'],
                'subrubro'    => $nombres['subrubro'],
                'imagen_url'  => $p['imagen_ruta'] ?? null,
            ];
        }, $rows);
    }

    /** Convierte un array plano de rubros en mapa keyed por slug para las vistas. */
    private function mapRubros(array $rubros): array
    {
        $map = [];
        foreach ($rubros as $r) {
            $map[$r['slug']] = [
                'id'          => (int) $r['id'],
                'nombre'      => $r['nombre'],
                'icono'       => $r['icono'] ?: 'fas fa-folder',
                'descripcion' => $r['descripcion'] ?? '',
            ];
        }
        return $map;
    }

    /**
     * Construye el array de subrubros keyed por slug a partir de los hijos directos.
     * Incluye conteo de nietos para mostrar "N subrubros" en las tarjetas.
     */
    private function buildSubrubros(array $children): array
    {
        $childIds = array_column($children, 'id');

        // Contar nietos por cada hijo en una sola query
        $db     = \Config\Database::connect();
        $gcRows = $db->table('categorias')
            ->select('parent_id, COUNT(*) as cnt')
            ->whereIn('parent_id', $childIds)
            ->where('activo', 1)
            ->groupBy('parent_id')
            ->get()
            ->getResultArray();

        $gcCounts = [];
        foreach ($gcRows as $row) {
            $gcCounts[(int) $row['parent_id']] = (int) $row['cnt'];
        }

        $subrubros = [];
        foreach ($children as $child) {
            $entry = [
                'id'          => (int) $child['id'],
                'nombre'      => $child['nombre'],
                'icono'       => $child['icono'] ?: 'fas fa-folder',
                'descripcion' => $child['descripcion'] ?? '',
            ];

            $gcCount = $gcCounts[(int) $child['id']] ?? 0;
            if ($gcCount > 0) {
                // Tiene sub-categorías: pasar array con el conteo para que la vista lo muestre
                $entry['subrubros'] = array_fill(0, $gcCount, []);
            }

            $subrubros[$child['slug']] = $entry;
        }

        return $subrubros;
    }

    /**
     * Retorna las categorías hermanas para los chips de navegación del header.
     * Para nivel-1 (parent_id null): todos los rubros.
     * Para nivel-2/3: hermanos del mismo padre.
     */
    private function buildSiblings(array $dbCat, array $segments): array
    {
        $siblings = [];
        $nSeg     = count($segments);

        if ($dbCat['parent_id']) {
            $siblingCats = $this->catModel->getChildren((int) $dbCat['parent_id']);
            $parentPath  = 'catalogo/' . implode('/', array_slice($segments, 0, $nSeg - 1));

            foreach ($siblingCats as $sib) {
                $siblings[$sib['slug']] = [
                    'nombre' => $sib['nombre'],
                    'icono'  => $sib['icono'] ?: 'fas fa-folder',
                    'url'    => base_url($parentPath . '/' . $sib['slug']),
                    'activo' => ((int) $sib['id'] === (int) $dbCat['id']),
                ];
            }
        } else {
            // Nivel-1: hermanos = todos los rubros activos
            foreach ($this->catModel->getRubros() as $r) {
                $siblings[$r['slug']] = [
                    'nombre' => $r['nombre'],
                    'icono'  => $r['icono'] ?: 'fas fa-folder',
                    'url'    => base_url('catalogo/' . $r['slug']),
                    'activo' => ($r['slug'] === ($segments[0] ?? '')),
                ];
            }
        }

        return $siblings;
    }
}
