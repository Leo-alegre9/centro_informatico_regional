<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoImagenModel extends Model
{
    protected $table         = 'producto_imagenes';
    protected $allowedFields = ['producto_id', 'ruta', 'alt_text', 'es_principal', 'orden'];
    protected $useTimestamps = true;

    public function getPrincipal(int $productoId): ?array
    {
        return $this->where('producto_id', $productoId)->where('es_principal', 1)->first();
    }

    public function getByProducto(int $productoId): array
    {
        return $this->where('producto_id', $productoId)
                    ->orderBy('es_principal', 'DESC')
                    ->orderBy('orden', 'ASC')
                    ->findAll();
    }
}
