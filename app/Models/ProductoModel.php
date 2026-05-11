<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table         = 'productos';
    protected $allowedFields = [
        'categoria_id', 'marca_id', 'nombre', 'descripcion_corta',
        'descripcion', 'precio_texto', 'precio_numero', 'badge', 'icono', 'activo', 'orden',
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
}
