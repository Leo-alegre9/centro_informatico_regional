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
        $rubroMap = $this->mapRubros($this->catModel->getRubros());

        return view('catalogo_rubro', [
            'titulo'      => 'Catálogo | Centro Informático Regional',
            'breadcrumb'  => [
                ['nombre' => 'Inicio',   'url' => base_url()],
                ['nombre' => 'Catálogo', 'url' => null],
            ],
            'current'     => [
                'nombre'      => 'Catálogo',
                'icono'       => 'fas fa-th-large',
                'descripcion' => 'Explorá todos nuestros rubros y encontrá lo que necesitás.',
                'subrubros'   => $rubroMap,
            ],
            'currentPath' => 'catalogo',
            'siblings'    => [],
            'allRubros'   => $rubroMap,
            'destacados'  => [],
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

        if (!empty($children)) {
            // Tiene hijos → mostrar grilla de subrubros
            $current['subrubros'] = $this->buildSubrubros($children);
        } else {
            // Hoja → cargar productos de la BD
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
                    'nombre'           => $p['nombre'],
                    'descripcion'      => $p['descripcion_corta'] ?? '',
                    'descripcion_full' => $p['descripcion'] ?? $p['descripcion_corta'] ?? '',
                    'precio'           => $p['precio_texto'],
                    'badge'            => $p['badge'],
                    'icono'            => $p['icono'],
                    'imagen_url'       => !empty($imgsByProd[$p['id']]) ? $imgsByProd[$p['id']][0]['ruta'] : null,
                    'imagenes'         => $imgsByProd[$p['id']] ?? [],
                ];
            }, $dbProductos);
        }

        // 5. Hermanos (chips de navegación en el header)
        $siblings = $this->buildSiblings($dbCat, $segments);

        // 6. Productos destacados para el carrusel
        $descIds    = $this->catModel->getDescendantIds((int) $dbCat['id']);
        $destacados = $this->productoModel->getDestacadosByCatIds($descIds, 8);

        // 7. Índice de rubros
        $allRubros = $this->mapRubros($this->catModel->getRubros());

        return view('catalogo_rubro', [
            'titulo'      => $dbCat['nombre'] . ' | Centro Informático Regional',
            'breadcrumb'  => $breadcrumb,
            'current'     => $current,
            'currentPath' => $currentPath,
            'siblings'    => $siblings,
            'allRubros'   => $allRubros,
            'destacados'  => $destacados,
        ]);
    }

    // ── Búsqueda contextual AJAX (/catalogo/buscar) ───────────────────────────

    public function buscar(): \CodeIgniter\HTTP\ResponseInterface
    {
        $q      = trim((string) $this->request->getGet('q'));
        $rubro  = trim((string) $this->request->getGet('rubro'));
        $sub    = trim((string) $this->request->getGet('sub'));
        $subSub = trim((string) $this->request->getGet('subsub'));

        if ($q === '' || $rubro === '') {
            return $this->response->setJSON(['resultados' => [], 'total' => 0]);
        }

        $dbCat = $this->catModel->findBySlugPath(
            $rubro,
            $sub !== '' ? $sub : null,
            $subSub !== '' ? $subSub : null
        );

        if (!$dbCat) {
            return $this->response->setJSON(['resultados' => [], 'total' => 0]);
        }

        $descIds    = $this->catModel->getDescendantIds((int) $dbCat['id']);
        $resultados = $this->productoModel->buscarEnCategoria($descIds, $q);

        $out = array_map(fn($p) => [
            'id'         => $p['id'],
            'nombre'     => $p['nombre'],
            'modelo'     => $p['modelo'] ?? '',
            'precio'     => $p['precio_texto'],
            'badge'      => $p['badge'],
            'imagen_url' => $p['imagen_ruta'] ?? null,
            'marca'      => $p['marca_nombre'] ?? '',
        ], $resultados);

        return $this->response->setJSON(['resultados' => $out, 'total' => count($out)]);
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
