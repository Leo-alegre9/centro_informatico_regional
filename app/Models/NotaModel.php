<?php

namespace App\Models;

use CodeIgniter\Model;

class NotaModel extends Model
{
    protected $table         = 'notas';
    protected $allowedFields = ['autor', 'contenido'];
    protected $useTimestamps = true;

    public function getAll(): array
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }
}
