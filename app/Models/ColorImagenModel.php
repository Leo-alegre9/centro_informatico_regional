<?php

namespace App\Models;

use CodeIgniter\Model;

class ColorImagenModel extends Model
{
    protected $table         = 'producto_color_imagenes';
    protected $allowedFields = ['producto_color_id', 'imagen', 'texto_alternativo', 'es_principal', 'orden', 'activo'];
    protected $useTimestamps = true;

    /** Todas las imágenes de un color (admin), principal primero y luego por orden. */
    public function getByColor(int $productoColorId): array
    {
        return $this
            ->where('producto_color_id', $productoColorId)
            ->orderBy('es_principal', 'DESC')
            ->orderBy('orden', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();
    }

    /**
     * Imágenes activas de todos los colores activos de un producto, resueltas en una sola
     * consulta (evita N+1 en la ficha pública) y agrupadas en PHP por producto_color_id.
     *
     * @return array<int, array> mapa producto_color_id => imágenes ordenadas (principal primero)
     */
    public function getActivasAgrupadasPorProducto(int $productoId): array
    {
        $filas = $this
            ->select('producto_color_imagenes.*')
            ->join('producto_color_variantes pcv', 'pcv.id = producto_color_imagenes.producto_color_id')
            ->where('pcv.producto_id', $productoId)
            ->where('pcv.activo', 1)
            ->where('producto_color_imagenes.activo', 1)
            ->orderBy('producto_color_imagenes.es_principal', 'DESC')
            ->orderBy('producto_color_imagenes.orden', 'ASC')
            ->orderBy('producto_color_imagenes.id', 'ASC')
            ->findAll();

        $agrupadas = [];
        foreach ($filas as $fila) {
            $agrupadas[(int) $fila['producto_color_id']][] = $fila;
        }

        return $agrupadas;
    }
}
