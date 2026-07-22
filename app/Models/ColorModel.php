<?php

namespace App\Models;

use CodeIgniter\Model;

class ColorModel extends Model
{
    protected $table         = 'colores';
    protected $allowedFields = ['nombre', 'hex'];
    protected $useTimestamps = true;

    /** Colores asignados a un producto, en el orden en que fueron cargados. */
    public function getByProducto(int $productoId): array
    {
        return $this
            ->select('colores.*')
            ->join('producto_colores', 'producto_colores.color_id = colores.id')
            ->where('producto_colores.producto_id', $productoId)
            ->orderBy('colores.nombre', 'ASC')
            ->findAll();
    }

    /**
     * Reemplaza completamente los colores de un producto a partir de una lista de nombres.
     * Crea los colores que no existan todavía (comportamiento tipo "tags").
     */
    public function sincronizarProducto(int $productoId, array $nombres): void
    {
        $db = $this->db;
        $db->table('producto_colores')->where('producto_id', $productoId)->delete();

        $nombres = array_values(array_unique(array_filter(array_map('trim', $nombres), fn($n) => $n !== '')));
        if (empty($nombres)) {
            return;
        }

        $rows = [];
        foreach ($nombres as $nombre) {
            $colorId = $this->obtenerOCrearId($nombre);
            $rows[]  = ['producto_id' => $productoId, 'color_id' => $colorId];
        }

        $db->table('producto_colores')->insertBatch($rows);
    }

    private function obtenerOCrearId(string $nombre): int
    {
        $existente = $this->where('nombre', $nombre)->first();
        if ($existente) {
            return (int) $existente['id'];
        }

        return (int) $this->insert(['nombre' => $nombre], true);
    }
}
