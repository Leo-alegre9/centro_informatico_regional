<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table         = 'productos';
    protected $allowedFields = [
        'categoria_id', 'marca_id', 'codigo', 'nombre', 'modelo', 'descripcion_corta',
        'descripcion', 'precio_texto', 'precio_numero', 'precio_dolar', 'badge', 'icono', 'activo', 'destacado', 'orden', 'ubicacion', 'stock',
    ];
    protected $useTimestamps = true;

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
