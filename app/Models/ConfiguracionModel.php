<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfiguracionModel extends Model
{
    protected $table         = 'configuracion';
    protected $allowedFields = ['clave', 'valor'];
    protected $useTimestamps = true;

    public function get(string $clave, $default = null)
    {
        $row = $this->where('clave', $clave)->first();
        return $row !== null ? $row['valor'] : $default;
    }

    public function guardarClave(string $clave, $valor): void
    {
        $existing = $this->where('clave', $clave)->first();
        if ($existing) {
            $this->where('clave', $clave)->update(null, ['valor' => $valor]);
        } else {
            $this->insert(['clave' => $clave, 'valor' => $valor]);
        }
    }

    public function getAll(): array
    {
        $result = [];
        foreach ($this->findAll() as $row) {
            $result[$row['clave']] = $row['valor'];
        }
        return $result;
    }
}
