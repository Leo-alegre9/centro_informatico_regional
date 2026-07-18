<?php

namespace App\Models;

use CodeIgniter\Model;

class FabricaModel extends Model
{
    protected $table         = 'fabricas';
    protected $allowedFields = ['nombre', 'slug', 'activo'];
    protected $useTimestamps = true;

    public function getActivas(): array
    {
        return $this->where('activo', 1)->orderBy('nombre', 'ASC')->findAll();
    }
}
