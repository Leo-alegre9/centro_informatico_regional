<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table         = 'productos';
    protected $allowedFields = [
        'categoria_id', 'marca_id', 'fabrica_id', 'codigo', 'nombre', 'slug', 'modelo', 'descripcion_corta',
        'descripcion', 'url_fabricante', 'precio_texto', 'precio_numero', 'precio_dolar', 'badge', 'icono', 'activo', 'destacado', 'orden', 'ubicacion', 'stock',
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
            ->select('productos.*, marcas.nombre AS marca_nombre, fabricas.nombre AS fabrica_nombre, categorias.nombre AS categoria_nombre')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->join('fabricas', 'fabricas.id = productos.fabrica_id', 'left')
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

    // ── Consultas sin secciones (backward compat) ─────────────────────────────

    public function getByCategoriaId(int $categoriaId): array
    {
        return $this
            ->select('productos.*, marcas.nombre AS marca_nombre, marcas.logo_url AS marca_logo')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
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
            ->select('productos.*, pi.ruta AS imagen_ruta, marcas.nombre AS marca_nombre, categorias.nombre AS categoria_nombre')
            ->join('producto_imagenes pi', 'pi.producto_id = productos.id AND pi.es_principal = 1', 'left')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->where('productos.activo', 1);

        if (!empty($catIds)) {
            $builder->whereIn('productos.categoria_id', $catIds);
        }

        return $builder
            ->groupStart()
                ->like('productos.nombre', $q)
                ->orLike('productos.modelo', $q)
                ->orLike('productos.descripcion_corta', $q)
                ->orLike('marcas.nombre', $q)
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
            ->select('productos.*, pi.ruta AS imagen_ruta, marcas.nombre AS marca_nombre, categorias.nombre AS categoria_nombre')
            ->join('producto_imagenes pi', 'pi.producto_id = productos.id AND pi.es_principal = 1', 'left')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->where('productos.activo', 1)
            ->groupStart()
                ->like('productos.nombre', $q)
                ->orLike('productos.modelo', $q)
                ->orLike('productos.descripcion_corta', $q)
                ->orLike('marcas.nombre', $q)
            ->groupEnd()
            ->orderBy('productos.orden', 'ASC')
            ->orderBy('productos.nombre', 'ASC')
            ->limit($limit)
            ->findAll();
    }

    public function buscarAdmin(string $q, string $tipo = 'todos'): array
    {
        if ($q === '') {
            return [];
        }

        $builder = $this
            ->select('productos.*, marcas.nombre AS marca_nombre, categorias.nombre AS categoria_nombre, pi.ruta AS imagen_ruta')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->join('categorias', 'categorias.id = productos.categoria_id', 'left')
            ->join('producto_imagenes pi', 'pi.producto_id = productos.id AND pi.es_principal = 1', 'left');

        switch ($tipo) {
            case 'codigo':
                $builder->like('productos.codigo', $q);
                break;
            case 'nombre':
                $builder->like('productos.nombre', $q);
                break;
            default:
                $builder->groupStart()
                    ->like('productos.codigo', $q)
                    ->orLike('productos.nombre', $q)
                    ->orLike('productos.modelo', $q)
                    ->orLike('marcas.nombre', $q)
                    ->orLike('productos.descripcion_corta', $q)
                ->groupEnd();
        }

        return $builder->orderBy('productos.nombre', 'ASC')->findAll();
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
