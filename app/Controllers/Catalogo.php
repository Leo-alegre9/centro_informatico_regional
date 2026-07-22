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

        if (!empty($children)) {
            // Tiene hijos → mostrar grilla de subrubros
            $current['subrubros'] = $this->buildSubrubros($children);

            // Destacados del rubro: productos de sección "rubro" en descendientes
            $todosIds         = array_merge([(int) $dbCat['id']], $descIds);
            $productosSeccion = $this->productoModel->getPorSeccionEnDescendientes($todosIds, 'rubro', 12);
            $tituloSeccion    = 'Destacados en ' . $dbCat['nombre'];
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

            $current['productos'] = array_map(function ($p) use ($imgsByProd) {
                return [
                    'id'               => $p['id'],
                    'slug'             => $p['slug'] ?? '',
                    'nombre'           => $p['nombre'],
                    'descripcion'      => $p['descripcion_corta'] ?? '',
                    'descripcion_full' => $p['descripcion'] ?? $p['descripcion_corta'] ?? '',
                    'precio'           => $p['precio_texto'],
                    'precio_num'       => $p['precio_numero'] ?? null,
                    'badge'            => $p['badge'],
                    'icono'            => $p['icono'],
                    'marca'            => $p['marca_nombre'] ?? '',
                    'imagen_url'       => !empty($imgsByProd[$p['id']]) ? $imgsByProd[$p['id']][0]['ruta'] : null,
                    'imagenes'         => $imgsByProd[$p['id']] ?? [],
                ];
            }, $dbProductos);

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
                'nombre'      => $p['nombre'],
                'modelo'      => $p['modelo'] ?? '',
                'precio'      => $p['precio_texto'],
                'badge'       => $p['badge'],
                'imagen_url'  => $p['imagen_ruta'] ?? null,
                'icono'       => $p['icono'] ?? 'fas fa-box',
                'descripcion' => $p['descripcion_corta'] ?? $p['descripcion'] ?? '',
                'marca'       => $p['marca_nombre'] ?? '',
                'categoria'   => $p['categoria_nombre'] ?? '',
            ], $resultados);

            return $this->response->setJSON(['resultados' => $out, 'total' => count($out)]);
        }

        // ── Petición normal (formulario del header): renderizar vista ──
        if ($q === '') {
            return redirect()->to(base_url('catalogo'));
        }

        $resultados = $this->productoModel->buscarGlobal($q);

        $productos = array_map(function ($p) {
            return [
                'id'           => $p['id'],
                'nombre'       => $p['nombre'],
                'modelo'       => $p['modelo'] ?? '',
                'precio'       => $p['precio_texto'],
                'badge'        => $p['badge'],
                'imagen_url'   => $p['imagen_ruta'] ?? null,
                'icono'        => $p['icono'] ?? 'fas fa-box',
                'descripcion'  => $p['descripcion_corta'] ?? '',
                'marca'        => $p['marca_nombre'] ?? '',
                'categoria'    => $p['categoria_nombre'] ?? '',
                'url_producto' => base_url('producto/' . ($p['slug'] ?: $p['id'])),
            ];
        }, $resultados);

        return view('catalogo_buscar', [
            'titulo'    => 'Resultados para "' . esc($q) . '" | Centro Informático Regional',
            'query'     => $q,
            'productos' => $productos,
            'total'     => count($productos),
        ]);
    }

    // ── Helpers privados ───────────────────────────────────────────────────────

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
