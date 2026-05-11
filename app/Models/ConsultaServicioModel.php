<?php

namespace App\Models;

use CodeIgniter\Model;

class ConsultaServicioModel extends Model
{
    protected $table         = 'consultas_servicio';
    protected $allowedFields = [
        'nombre_cliente', 'tipo_equipo', 'marca_modelo',
        'descripcion_problema', 'urgencia',
        'tecnico_contactado', 'numero_tecnico',
        'ip_cliente', 'estado',
    ];
    protected $useTimestamps = true;

    public function getAll(array $filtros = []): array
    {
        $q = $this->orderBy('created_at', 'DESC');

        if (!empty($filtros['tecnico'])) {
            $q->where('tecnico_contactado', $filtros['tecnico']);
        }
        if (!empty($filtros['estado'])) {
            $q->where('estado', $filtros['estado']);
        }
        if (!empty($filtros['urgencia'])) {
            $q->where('urgencia', $filtros['urgencia']);
        }

        return $q->findAll();
    }

    public function getUnreadCount(): int
    {
        return (int) $this->where('estado', 'nueva')->countAllResults();
    }

    public function getStats(): array
    {
        $hoy    = date('Y-m-d');
        $semana = date('Y-m-d', strtotime('-7 days'));

        return [
            'total'       => $this->countAll(),
            'sin_leer'    => $this->where('estado', 'nueva')->countAllResults(),
            'hoy'         => $this->where("DATE(created_at) = '{$hoy}'")->countAllResults(),
            'esta_semana' => $this->where('created_at >=', $semana . ' 00:00:00')->countAllResults(),
        ];
    }

    public function marcarVista(int $id): void
    {
        $this->update($id, ['estado' => 'vista']);
    }

    public function marcarResuelta(int $id): void
    {
        $this->update($id, ['estado' => 'resuelta']);
    }
}
