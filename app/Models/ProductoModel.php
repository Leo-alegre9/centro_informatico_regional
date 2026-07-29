<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table         = 'productos';
    protected $allowedFields = [
        'categoria_id', 'marca_id', 'fabrica_id', 'linea_id', 'codigo', 'nombre', 'slug', 'modelo', 'descripcion_corta',
        'descripcion', 'url_fabricante', 'precio_texto', 'precio_numero', 'precio_dolar', 'precio_interno', 'badge', 'icono', 'activo', 'destacado', 'orden', 'ubicacion', 'stock',
        'ancho', 'alto', 'profundidad', 'unidad_medida', 'material',
    ];
    protected $useTimestamps = true;

    // ── Slug ───────────────────────────────────────────────────────────────────

    /** Genera un slug único a partir del nombre, desambiguando con sufijo -2, -3... si ya existe. */
    public function generarSlugUnico(string $nombre, ?int $excludeId = null): string
    {
        $base = mb_strtolower(trim($nombre), 'UTF-8');
        $base = strtr($base, [
            'á' => 'a', 'à' => 'a', 'ä' => 'a', 'é' => 'e', 'è' => 'e', 'ë' => 'e',
            'í' => 'i', 'ì' => 'i', 'ï' => 'i', 'ó' => 'o', 'ò' => 'o', 'ö' => 'o',
            'ú' => 'u', 'ù' => 'u', 'ü' => 'u', 'ñ' => 'n',
        ]);
        $base = preg_replace('/[^a-z0-9]+/', '-', $base);
        $base = trim($base, '-');
        if ($base === '') {
            $base = 'producto';
        }
        $base = mb_substr($base, 0, 200);

        $slug     = $base;
        $sufijo   = 2;
        while (true) {
            $builder = $this->where('slug', $slug);
            if ($excludeId !== null) {
                $builder->where('id !=', $excludeId);
            }
            if (!$builder->first()) {
                return $slug;
            }
            $slug = $base . '-' . $sufijo;
            $sufijo++;
        }
    }

    /**
     * Busca un producto para la página de detalle, primero por slug y, si no matchea
     * y el valor es numérico, hace fallback por id (compatibilidad con enlaces viejos).
     */
    public function getBySlugOrId(string $valor): ?array
    {
        $producto = $this
            ->select('productos.*, marcas.nombre AS marca_nombre, fabricas.nombre AS fabrica_nombre, lineas.nombre AS linea_nombre, categorias.nombre AS categoria_nombre')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->join('fabricas', 'fabricas.id = productos.fabrica_id', 'left')
            ->join('lineas', 'lineas.id = productos.linea_id', 'left')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->where('productos.activo', 1)
            ->where('productos.slug', $valor)
            ->first();

        if (!$producto && ctype_digit($valor)) {
            $producto = $this
                ->select('productos.*, marcas.nombre AS marca_nombre, fabricas.nombre AS fabrica_nombre, categorias.nombre AS categoria_nombre')
                ->join('marcas', 'marcas.id = productos.marca_id', 'left')
                ->join('fabricas', 'fabricas.id = productos.fabrica_id', 'left')
                ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
                ->where('productos.activo', 1)
                ->where('productos.id', (int) $valor)
                ->first();
        }

        return $producto ?: null;
    }

    /**
     * Busca un producto por id con sus nombres relacionados (marca/fábrica/línea/categoría),
     * sin filtrar por activo. Uso exclusivo del panel admin (pantalla «Ver»).
     */
    public function getByIdConDetalle(int $id): ?array
    {
        $producto = $this
            ->select('productos.*, marcas.nombre AS marca_nombre, fabricas.nombre AS fabrica_nombre, lineas.nombre AS linea_nombre, categorias.nombre AS categoria_nombre')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->join('fabricas', 'fabricas.id = productos.fabrica_id', 'left')
            ->join('lineas', 'lineas.id = productos.linea_id', 'left')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->where('productos.id', $id)
            ->first();

        return $producto ?: null;
    }

    // ── Consultas sin secciones (backward compat) ─────────────────────────────

    public function getByCategoriaId(int $categoriaId): array
    {
        return $this
            ->select('productos.*, marcas.nombre AS marca_nombre, marcas.logo_url AS marca_logo, fabricas.nombre AS fabrica_nombre, lineas.nombre AS linea_nombre')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->join('fabricas', 'fabricas.id = productos.fabrica_id', 'left')
            ->join('lineas', 'lineas.id = productos.linea_id', 'left')
            ->where('productos.categoria_id', $categoriaId)
            ->where('productos.activo', 1)
            ->orderBy('productos.orden', 'ASC')
            ->orderBy('productos.nombre', 'ASC')
            ->findAll();
    }

    public function getByPath(string $rubro, string $subrubro, ?string $subSub = null): array
    {
        $catModel  = new CategoriaModel();
        $categoria = $catModel->findBySlugPath($rubro, $subrubro, ($subSub !== '') ? $subSub : null);
        if (!$categoria) {
            return [];
        }
        return $this->getByCategoriaId($categoria['id']);
    }

    public function getAllForAdmin(): array
    {
        return $this
            ->select('productos.*')
            ->orderBy('categoria_id', 'ASC')
            ->orderBy('orden', 'ASC')
            ->findAll();
    }

    /** Productos con destacado=1 (para carruseles de páginas de categoría). */
    public function getDestacados(): array
    {
        return $this
            ->select('productos.*, pi.ruta AS imagen_ruta, pi.alt_text AS imagen_alt, c.nombre AS categoria_nombre')
            ->join('producto_imagenes pi', 'pi.producto_id = productos.id AND pi.es_principal = 1', 'left')
            ->join('categorias c', 'c.id = productos.categoria_id', 'left')
            ->where('productos.activo', 1)
            ->where('productos.destacado', 1)
            ->orderBy('productos.orden', 'ASC')
            ->orderBy('productos.nombre', 'ASC')
            ->findAll();
    }

    /** Productos destacados filtrados por categorías (carruseles de catálogo). */
    public function getDestacadosByCatIds(array $catIds, int $limit = 8): array
    {
        if (empty($catIds)) {
            return [];
        }
        return $this
            ->select('productos.*, pi.ruta AS imagen_ruta, pi.alt_text AS imagen_alt, marcas.nombre AS marca_nombre')
            ->join('producto_imagenes pi', 'pi.producto_id = productos.id AND pi.es_principal = 1', 'left')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->whereIn('productos.categoria_id', $catIds)
            ->where('productos.activo', 1)
            ->where('productos.destacado', 1)
            ->orderBy('productos.orden', 'ASC')
            ->limit($limit)
            ->findAll();
    }

    public function buscarEnCategoria(array $catIds, string $q): array
    {
        if ($q === '') {
            return [];
        }
        $q = trim($q);
        $builder = $this
            ->select('productos.*, pi.ruta AS imagen_ruta, marcas.nombre AS marca_nombre, fabricas.nombre AS fabrica_nombre, lineas.nombre AS linea_nombre, categorias.nombre AS categoria_nombre')
            ->join('producto_imagenes pi', 'pi.producto_id = productos.id AND pi.es_principal = 1', 'left')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->join('fabricas', 'fabricas.id = productos.fabrica_id', 'left')
            ->join('lineas', 'lineas.id = productos.linea_id', 'left')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->where('productos.activo', 1);

        if (!empty($catIds)) {
            $builder->whereIn('productos.categoria_id', $catIds);
        }

        return $builder
            ->groupStart()
                ->like('productos.codigo', $q)
                ->orLike('productos.nombre', $q)
                ->orLike('productos.modelo', $q)
                ->orLike('productos.descripcion_corta', $q)
                ->orLike('marcas.nombre', $q)
                ->orLike('fabricas.nombre', $q)
                ->orLike('lineas.nombre', $q)
            ->groupEnd()
            ->orderBy('productos.orden', 'ASC')
            ->orderBy('productos.nombre', 'ASC')
            ->limit(30)
            ->findAll();
    }

    public function buscarGlobal(string $q, int $limit = 30): array
    {
        if ($q === '') {
            return [];
        }
        return $this
            ->select('productos.*, pi.ruta AS imagen_ruta, marcas.nombre AS marca_nombre, fabricas.nombre AS fabrica_nombre, lineas.nombre AS linea_nombre, categorias.nombre AS categoria_nombre')
            ->join('producto_imagenes pi', 'pi.producto_id = productos.id AND pi.es_principal = 1', 'left')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->join('fabricas', 'fabricas.id = productos.fabrica_id', 'left')
            ->join('lineas', 'lineas.id = productos.linea_id', 'left')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->where('productos.activo', 1)
            ->groupStart()
                ->like('productos.codigo', $q)
                ->orLike('productos.nombre', $q)
                ->orLike('productos.modelo', $q)
                ->orLike('productos.descripcion_corta', $q)
                ->orLike('marcas.nombre', $q)
                ->orLike('fabricas.nombre', $q)
                ->orLike('lineas.nombre', $q)
            ->groupEnd()
            ->orderBy('productos.orden', 'ASC')
            ->orderBy('productos.nombre', 'ASC')
            ->limit($limit)
            ->findAll();
    }

    public function buscarStock(string $q = ''): array
    {
        $builder = $this
            ->select('productos.id, productos.codigo, productos.nombre, productos.modelo, productos.stock, productos.activo, marcas.nombre AS marca_nombre, categorias.nombre AS categoria_nombre')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->orderBy('productos.nombre', 'ASC');

        if ($q !== '') {
            $builder->groupStart()
                ->like('productos.codigo', $q)
                ->orLike('productos.nombre', $q)
                ->orLike('productos.modelo', $q)
                ->orLike('marcas.nombre', $q)
            ->groupEnd();
        }

        return $builder->findAll();
    }

    public function buscarInventario(string $ubicacion = '', string $q = ''): array
    {
        $builder = $this
            ->select('productos.*, marcas.nombre AS marca_nombre, categorias.nombre AS categoria_nombre')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->orderBy('productos.ubicacion', 'ASC')
            ->orderBy('categorias.nombre', 'ASC')
            ->orderBy('productos.nombre', 'ASC');

        if ($ubicacion !== '') {
            $builder->where('productos.ubicacion', $ubicacion);
        }

        if ($q !== '') {
            $builder->groupStart()
                ->like('productos.nombre', $q)
                ->orLike('productos.modelo', $q)
                ->orLike('marcas.nombre', $q)
                ->orLike('productos.descripcion_corta', $q)
            ->groupEnd();
        }

        return $builder->findAll();
    }

    // ── Búsqueda y filtrado centralizados ─────────────────────────────────────

    /**
     * Arma la consulta base combinando texto libre + filtros estructurados
     * (categoría/marca/fábrica/línea/estado/stock). Reutilizada tanto por el
     * catálogo público como por el buscador del admin, para no duplicar la
     * lógica de joins y condiciones en cada controlador.
     *
     * Filtros soportados: q, categoria_ids (array), marca_id, fabrica_id,
     * linea_id, activo ('0'|'1'|''), stock ('con'|'sin'|'').
     */
    private function construirConsultaFiltros(array $filtros, bool $soloActivos): self
    {
        $this
            ->select('productos.*, marcas.nombre AS marca_nombre, fabricas.nombre AS fabrica_nombre, lineas.nombre AS linea_nombre, categorias.nombre AS categoria_nombre, pi.ruta AS imagen_ruta')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->join('fabricas', 'fabricas.id = productos.fabrica_id', 'left')
            ->join('lineas', 'lineas.id = productos.linea_id', 'left')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->join('producto_imagenes pi', 'pi.producto_id = productos.id AND pi.es_principal = 1', 'left');

        if ($soloActivos) {
            $this->where('productos.activo', 1);
        } elseif (($filtros['activo'] ?? '') !== '') {
            $this->where('productos.activo', (int) $filtros['activo']);
        }

        if (!empty($filtros['categoria_ids'])) {
            $this->whereIn('productos.categoria_id', $filtros['categoria_ids']);
        }
        if (!empty($filtros['marca_id'])) {
            $this->where('productos.marca_id', (int) $filtros['marca_id']);
        }
        if (!empty($filtros['fabrica_id'])) {
            $this->where('productos.fabrica_id', (int) $filtros['fabrica_id']);
        }
        if (!empty($filtros['linea_id'])) {
            $this->where('productos.linea_id', (int) $filtros['linea_id']);
        }

        if (($filtros['stock'] ?? '') === 'con') {
            $this->where('productos.stock >', 0);
        } elseif (($filtros['stock'] ?? '') === 'sin') {
            $this->where('productos.stock', 0);
        }

        $q = trim((string) ($filtros['q'] ?? ''));
        if ($q !== '') {
            $tipo = $filtros['tipo'] ?? 'todos';
            if ($tipo === 'codigo') {
                $this->like('productos.codigo', $q);
            } elseif ($tipo === 'nombre') {
                $this->like('productos.nombre', $q);
            } else {
                $this->groupStart()
                    ->like('productos.codigo', $q)
                    ->orLike('productos.nombre', $q)
                    ->orLike('productos.modelo', $q)
                    ->orLike('marcas.nombre', $q)
                    ->orLike('fabricas.nombre', $q)
                    ->orLike('lineas.nombre', $q)
                    ->orLike('categorias.nombre', $q)
                    ->orLike('productos.descripcion_corta', $q)
                    ->orLike('productos.descripcion', $q)
                ->groupEnd();
            }
        }

        return $this;
    }

    private function aplicarOrden(self $builder, string $orden): void
    {
        switch ($orden) {
            case 'az':
                $builder->orderBy('productos.nombre', 'ASC');
                break;
            case 'za':
                $builder->orderBy('productos.nombre', 'DESC');
                break;
            case 'precio_asc':
                $builder->orderBy('productos.precio_numero', 'ASC');
                break;
            case 'precio_desc':
                $builder->orderBy('productos.precio_numero', 'DESC');
                break;
            default:
                $builder->orderBy('productos.destacado', 'DESC')
                    ->orderBy('productos.orden', 'ASC')
                    ->orderBy('productos.nombre', 'ASC');
        }
    }

    /**
     * Búsqueda + filtros combinados para el catálogo público, paginada.
     * Solo devuelve productos activos.
     *
     * @return array{resultados: array, pager: \CodeIgniter\Pager\Pager}
     */
    public function buscarProductos(array $filtros, int $porPagina = 24): array
    {
        $this->construirConsultaFiltros($filtros, true);
        $this->aplicarOrden($this, (string) ($filtros['orden'] ?? ''));

        $resultados = $this->paginate($porPagina, 'catalogo');

        return ['resultados' => $resultados, 'pager' => $this->pager];
    }

    /**
     * Búsqueda + filtros combinados para el panel de administración, paginada.
     * A diferencia de buscarProductos(), puede incluir productos inactivos
     * (filtro "estado") y filtrar por stock.
     *
     * @return array{resultados: array, pager: \CodeIgniter\Pager\Pager}
     */
    public function buscarProductosAdmin(array $filtros, int $porPagina = 30): array
    {
        $this->construirConsultaFiltros($filtros, false);
        $this->orderBy('productos.nombre', 'ASC');

        $resultados = $this->paginate($porPagina, 'admin_productos');

        return ['resultados' => $resultados, 'pager' => $this->pager];
    }

    /**
     * Devuelve las marcas, fábricas y líneas que efectivamente tienen productos
     * dentro del contexto dado (categorías/fábrica seleccionadas), para poblar
     * selects de filtro sin mostrar opciones vacías. No usa $this para no
     * pisar el estado de otras consultas encadenadas del modelo.
     */
    public function obtenerOpcionesFiltros(array $filtros, bool $soloActivos = true): array
    {
        $categoriaIds = $filtros['categoria_ids'] ?? [];
        $fabricaId    = (int) ($filtros['fabrica_id'] ?? 0);
        $db           = \Config\Database::connect();

        $marcas = $db->table('productos')
            ->select('marcas.id, marcas.nombre')
            ->join('marcas', 'marcas.id = productos.marca_id', 'inner')
            ->distinct();
        if ($soloActivos) {
            $marcas->where('productos.activo', 1);
        }
        if (!empty($categoriaIds)) {
            $marcas->whereIn('productos.categoria_id', $categoriaIds);
        }
        $marcas = $marcas->orderBy('marcas.nombre', 'ASC')->get()->getResultArray();

        $fabricas = $db->table('productos')
            ->select('fabricas.id, fabricas.nombre')
            ->join('fabricas', 'fabricas.id = productos.fabrica_id', 'inner')
            ->distinct();
        if ($soloActivos) {
            $fabricas->where('productos.activo', 1);
        }
        if (!empty($categoriaIds)) {
            $fabricas->whereIn('productos.categoria_id', $categoriaIds);
        }
        $fabricas = $fabricas->orderBy('fabricas.nombre', 'ASC')->get()->getResultArray();

        $lineas = $db->table('productos')
            ->select('lineas.id, lineas.nombre')
            ->join('lineas', 'lineas.id = productos.linea_id', 'inner')
            ->distinct();
        if ($soloActivos) {
            $lineas->where('productos.activo', 1);
        }
        if (!empty($categoriaIds)) {
            $lineas->whereIn('productos.categoria_id', $categoriaIds);
        }
        if ($fabricaId > 0) {
            $lineas->where('productos.fabrica_id', $fabricaId);
        }
        $lineas = $lineas->orderBy('lineas.nombre', 'ASC')->get()->getResultArray();

        return ['marcas' => $marcas, 'fabricas' => $fabricas, 'lineas' => $lineas];
    }

    /**
     * Productos activos filtrables del lado del cliente (chips de marca/fábrica/línea/
     * rubro/subrubro en JS, sin recargar la página). Sin paginar, igual que el resto de
     * las consultas de catálogo por categoría: pensado para catálogos de tamaño moderado.
     * Si $catIds está vacío, devuelve todos los productos activos (catálogo general).
     */
    public function getFiltrablesPorCategorias(array $catIds = []): array
    {
        $builder = $this
            ->select('productos.*, marcas.nombre AS marca_nombre, fabricas.nombre AS fabrica_nombre, lineas.nombre AS linea_nombre, categorias.nombre AS categoria_nombre, pi.ruta AS imagen_ruta')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->join('fabricas', 'fabricas.id = productos.fabrica_id', 'left')
            ->join('lineas', 'lineas.id = productos.linea_id', 'left')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->join('producto_imagenes pi', 'pi.producto_id = productos.id AND pi.es_principal = 1', 'left')
            ->where('productos.activo', 1);

        if (!empty($catIds)) {
            $builder->whereIn('productos.categoria_id', $catIds);
        }

        return $builder
            ->orderBy('productos.orden', 'ASC')
            ->orderBy('productos.nombre', 'ASC')
            ->findAll();
    }

    public function getRelacionados(int $catId, int $excluirId, int $limit = 4): array
    {
        return $this
            ->select('productos.*, pi.ruta AS imagen_ruta, marcas.nombre AS marca_nombre')
            ->join('producto_imagenes pi', 'pi.producto_id = productos.id AND pi.es_principal = 1', 'left')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->where('productos.categoria_id', $catId)
            ->where('productos.activo', 1)
            ->where('productos.id !=', $excluirId)
            ->orderBy('productos.destacado', 'DESC')
            ->orderBy('productos.orden', 'ASC')
            ->limit($limit)
            ->findAll();
    }

    // ── Consultas con secciones ───────────────────────────────────────────────

    /**
     * Productos asignados a la sección "inicio" para el carrusel del homepage.
     * Reemplaza la lógica anterior basada en el campo destacado.
     */
    public function getParaInicio(): array
    {
        return $this
            ->select('productos.*, pi.ruta AS imagen_ruta, pi.alt_text AS imagen_alt, c.nombre AS categoria_nombre')
            ->join('producto_secciones ps', 'ps.producto_id = productos.id AND ps.activo = 1', 'inner')
            ->join('secciones s', 's.id = ps.seccion_id', 'inner')
            ->join('producto_imagenes pi', 'pi.producto_id = productos.id AND pi.es_principal = 1', 'left')
            ->join('categorias c', 'c.id = productos.categoria_id', 'left')
            ->where('productos.activo', 1)
            ->where('s.slug', 'inicio')
            ->where('s.activo', 1)
            ->orderBy('ps.orden', 'ASC')
            ->orderBy('productos.orden', 'ASC')
            ->orderBy('productos.nombre', 'ASC')
            ->findAll();
    }

    /**
     * Productos de una categoría filtrados por sección.
     * Usado en Catalogo::browse() para páginas de subrubro.
     */
    public function getByCategoriaIdYSeccion(int $categoriaId, string $seccionSlug): array
    {
        return $this
            ->select('productos.*, marcas.nombre AS marca_nombre, marcas.logo_url AS marca_logo')
            ->join('producto_secciones ps', 'ps.producto_id = productos.id AND ps.activo = 1', 'inner')
            ->join('secciones s', 's.id = ps.seccion_id', 'inner')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->where('productos.categoria_id', $categoriaId)
            ->where('productos.activo', 1)
            ->where('s.slug', $seccionSlug)
            ->where('s.activo', 1)
            ->orderBy('ps.orden', 'ASC')
            ->orderBy('productos.orden', 'ASC')
            ->orderBy('productos.nombre', 'ASC')
            ->findAll();
    }

    /**
     * Productos de descendientes asignados a la sección "destacado".
     * Reemplaza getDestacadosByCatIds() en Catalogo::browse() para carruseles.
     */
    public function getDestacadosByCatIdsYSeccion(array $catIds, int $limit = 8): array
    {
        if (empty($catIds)) {
            return [];
        }

        return $this
            ->select('productos.*, pi.ruta AS imagen_ruta, pi.alt_text AS imagen_alt, marcas.nombre AS marca_nombre')
            ->join('producto_secciones ps', 'ps.producto_id = productos.id AND ps.activo = 1', 'inner')
            ->join('secciones s', 's.id = ps.seccion_id', 'inner')
            ->join('producto_imagenes pi', 'pi.producto_id = productos.id AND pi.es_principal = 1', 'left')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->whereIn('productos.categoria_id', $catIds)
            ->where('productos.activo', 1)
            ->where('s.slug', 'destacado')
            ->where('s.activo', 1)
            ->orderBy('ps.orden', 'ASC')
            ->orderBy('productos.orden', 'ASC')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Productos asignados a una sección sin filtrar por categoría.
     * Usado en Catalogo::index() para la sección 'catalogo'.
     */
    public function getBySeccion(string $seccionSlug, int $limit = 12): array
    {
        $q = $this
            ->select('productos.*, pi.ruta AS imagen_ruta, pi.alt_text AS imagen_alt, marcas.nombre AS marca_nombre, c.nombre AS categoria_nombre')
            ->join('producto_secciones ps', 'ps.producto_id = productos.id AND ps.activo = 1', 'inner')
            ->join('secciones s', 's.id = ps.seccion_id', 'inner')
            ->join('producto_imagenes pi', 'pi.producto_id = productos.id AND pi.es_principal = 1', 'left')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->join('categorias c', 'c.id = productos.categoria_id', 'left')
            ->where('productos.activo', 1)
            ->where('s.slug', $seccionSlug)
            ->where('s.activo', 1)
            ->orderBy('ps.orden', 'ASC')
            ->orderBy('productos.orden', 'ASC');

        if ($limit > 0) {
            $q->limit($limit);
        }

        return $q->findAll();
    }

    /**
     * Productos de categorías descendientes asignados a una sección específica.
     * Usado en Catalogo::browse() para páginas de rubro (sección 'rubro').
     */
    public function getPorSeccionEnDescendientes(array $catIds, string $seccionSlug, int $limit = 12): array
    {
        if (empty($catIds)) {
            return [];
        }

        return $this
            ->select('productos.*, pi.ruta AS imagen_ruta, pi.alt_text AS imagen_alt, marcas.nombre AS marca_nombre, c.nombre AS categoria_nombre')
            ->join('producto_secciones ps', 'ps.producto_id = productos.id AND ps.activo = 1', 'inner')
            ->join('secciones s', 's.id = ps.seccion_id', 'inner')
            ->join('producto_imagenes pi', 'pi.producto_id = productos.id AND pi.es_principal = 1', 'left')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->join('categorias c', 'c.id = productos.categoria_id', 'left')
            ->whereIn('productos.categoria_id', $catIds)
            ->where('productos.activo', 1)
            ->where('s.slug', $seccionSlug)
            ->where('s.activo', 1)
            ->orderBy('ps.orden', 'ASC')
            ->orderBy('productos.orden', 'ASC')
            ->limit($limit)
            ->findAll();
    }
}
