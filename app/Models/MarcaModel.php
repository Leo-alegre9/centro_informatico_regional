<?php

namespace App\Models;

use CodeIgniter\Model;

class MarcaModel extends Model
{
    protected $table         = 'marcas';
    protected $allowedFields = ['nombre', 'slug', 'logo_url', 'sitio_web', 'activo'];
    protected $useTimestamps = true;

    public function getActivas(): array
    {
        return $this->where('activo', 1)->orderBy('nombre', 'ASC')->findAll();
    }
}
