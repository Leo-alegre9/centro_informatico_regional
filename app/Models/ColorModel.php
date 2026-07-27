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
     * Reemplaza completamente los colores de un producto a partir de una lista de pares
     * ['nombre' => string, 'hex' => ?string]. Crea los colores que no existan todavía
     * (comportamiento tipo "tags") y actualiza el hex si se indicó uno nuevo.
     */
    public function sincronizarProducto(int $productoId, array $colores): void
    {
        $db = $this->db;
        $db->table('producto_colores')->where('producto_id', $productoId)->delete();

        $vistos = [];
        $rows   = [];
        foreach ($colores as $color) {
            $nombre = trim((string) ($color['nombre'] ?? ''));
            if ($nombre === '' || isset($vistos[mb_strtolower($nombre)])) {
                continue;
            }
            $vistos[mb_strtolower($nombre)] = true;

            $hex     = $this->normalizarHex($color['hex'] ?? null);
            $colorId = $this->obtenerOCrearId($nombre, $hex);
            $rows[]  = ['producto_id' => $productoId, 'color_id' => $colorId];
        }

        if (!empty($rows)) {
            $db->table('producto_colores')->insertBatch($rows);
        }
    }

    private function obtenerOCrearId(string $nombre, ?string $hex): int
    {
        $existente = $this->where('nombre', $nombre)->first();
        if ($existente) {
            if ($hex !== null && $hex !== $existente['hex']) {
                $this->update($existente['id'], ['hex' => $hex]);
            }
            return (int) $existente['id'];
        }

        return (int) $this->insert(['nombre' => $nombre, 'hex' => $hex], true);
    }

    /** Valida que sea un color hexadecimal (#RGB o #RRGGBB); devuelve null si no es válido. */
    private function normalizarHex(?string $hex): ?string
    {
        $hex = trim((string) $hex);
        if ($hex === '') {
            return null;
        }
        return preg_match('/^#[0-9a-fA-F]{3}([0-9a-fA-F]{3})?$/', $hex) ? $hex : null;
    }
}
