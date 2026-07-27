<?php

namespace App\Models;

use CodeIgniter\Model;

class LineaModel extends Model
{
    protected $table         = 'lineas';
    protected $allowedFields = ['fabrica_id', 'nombre', 'slug', 'activo'];
    protected $useTimestamps = true;

    public function getByFabrica(int $fabricaId): array
    {
        return $this->where('fabrica_id', $fabricaId)->orderBy('nombre', 'ASC')->findAll();
    }

    public function getActivasByFabrica(int $fabricaId): array
    {
        return $this->where('fabrica_id', $fabricaId)->where('activo', 1)->orderBy('nombre', 'ASC')->findAll();
    }

    /** Mapa fabrica_id => [{id, nombre}] de líneas activas, para poblar el select dependiente del formulario de productos. */
    public function getMapaActivasPorFabrica(): array
    {
        $lineas = $this->where('activo', 1)->orderBy('nombre', 'ASC')->findAll();

        $mapa = [];
        foreach ($lineas as $l) {
            $mapa[(int) $l['fabrica_id']][] = ['id' => (int) $l['id'], 'nombre' => $l['nombre']];
        }
        return $mapa;
    }
}
