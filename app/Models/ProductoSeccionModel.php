<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoSeccionModel extends Model
{
    protected $table      = 'producto_secciones';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'producto_id', 'seccion_id', 'activo', 'orden', 'fecha_inicio', 'fecha_fin',
    ];
    protected $useTimestamps = true;

    /** Devuelve los IDs de sección asignados a un producto. */
    public function getSeccionIdsDeProducto(int $productoId): array
    {
        $rows = $this
            ->select('seccion_id')
            ->where('producto_id', $productoId)
            ->where('activo', 1)
            ->findAll();

        return array_column($rows, 'seccion_id');
    }

    /**
     * Reemplaza completamente las secciones de un producto.
     * Elimina las asignaciones anteriores e inserta las nuevas.
     */
    public function sincronizar(int $productoId, array $seccionIds): void
    {
        $this->where('producto_id', $productoId)->delete();

        if (empty($seccionIds)) {
            return;
        }

        $now  = date('Y-m-d H:i:s');
        $rows = [];

        foreach ($seccionIds as $seccionId) {
            $rows[] = [
                'producto_id' => $productoId,
                'seccion_id'  => (int) $seccionId,
                'activo'      => 1,
                'orden'       => 0,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }

        $this->db->table('producto_secciones')->insertBatch($rows);
    }

    /** Agrega o quita una sección de un producto (útil para toggles rápidos). */
    public function toggle(int $productoId, int $seccionId): bool
    {
        $existe = $this
            ->where('producto_id', $productoId)
            ->where('seccion_id', $seccionId)
            ->first();

        if ($existe) {
            $this->delete($existe['id']);
            return false;
        }

        $this->insert([
            'producto_id' => $productoId,
            'seccion_id'  => $seccionId,
            'activo'      => 1,
            'orden'       => 0,
        ]);
        return true;
    }
}
