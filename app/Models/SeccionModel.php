<?php

namespace App\Models;

use CodeIgniter\Model;

class SeccionModel extends Model
{
    protected $table      = 'secciones';
    protected $primaryKey = 'id';
    protected $allowedFields = ['slug', 'nombre', 'descripcion', 'icono', 'activo', 'orden'];
    protected $useTimestamps = true;

    public function getActivas(): array
    {
        return $this
            ->where('activo', 1)
            ->orderBy('orden', 'ASC')
            ->findAll();
    }

    /** Retorna [producto_id => [slug, ...]] para un conjunto de productos. */
    public function getSlugMapForProductos(array $productoIds): array
    {
        if (empty($productoIds)) {
            return [];
        }

        $rows = $this->db
            ->table('producto_secciones ps')
            ->select('ps.producto_id, s.slug')
            ->join('secciones s', 's.id = ps.seccion_id')
            ->whereIn('ps.producto_id', $productoIds)
            ->where('ps.activo', 1)
            ->where('s.activo', 1)
            ->get()
            ->getResultArray();

        $map = [];
        foreach ($rows as $row) {
            $map[(int) $row['producto_id']][] = $row['slug'];
        }

        return $map;
    }
}
