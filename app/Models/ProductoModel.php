<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table         = 'productos';
    protected $allowedFields = [
        'categoria_id', 'marca_id', 'nombre', 'modelo', 'descripcion_corta',
        'descripcion', 'precio_texto', 'precio_numero', 'badge', 'icono', 'activo', 'destacado', 'orden',
    ];
    protected $useTimestamps = true;

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
        $catModel = new CategoriaModel();
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
        if (empty($catIds) || $q === '') {
            return [];
        }
        $q = trim($q);
        return $this
            ->select('productos.*, pi.ruta AS imagen_ruta, marcas.nombre AS marca_nombre')
            ->join('producto_imagenes pi', 'pi.producto_id = productos.id AND pi.es_principal = 1', 'left')
            ->join('marcas', 'marcas.id = productos.marca_id', 'left')
            ->whereIn('productos.categoria_id', $catIds)
            ->where('productos.activo', 1)
            ->groupStart()
                ->like('productos.nombre', $q)
                ->orLike('productos.modelo', $q)
                ->orLike('productos.descripcion_corta', $q)
                ->orLike('marcas.nombre', $q)
            ->groupEnd()
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
}
