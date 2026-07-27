<?php

namespace App\Models;

use CodeIgniter\Model;

class ColorVarianteModel extends Model
{
    protected $table         = 'producto_color_variantes';
    protected $allowedFields = [
        'producto_id', 'nombre', 'tipo', 'color_primario', 'color_secundario', 'imagen_muestra', 'orden', 'activo',
    ];
    protected $useTimestamps = true;

    /** Todas las variantes de un producto (admin), en el orden definido. */
    public function getByProducto(int $productoId): array
    {
        return $this
            ->where('producto_id', $productoId)
            ->orderBy('orden', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();
    }

    /** Solo variantes activas de un producto (ficha pública), en el orden definido. */
    public function getActivasByProducto(int $productoId): array
    {
        return $this
            ->where('producto_id', $productoId)
            ->where('activo', 1)
            ->orderBy('orden', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();
    }

    /**
     * Construye el valor del atributo style="" para pintar una muestra de 42×42
     * según su tipo: color simple, combinación diagonal o imagen/textura.
     */
    public static function estiloSwatch(array $variante): string
    {
        $tipo = $variante['tipo'] ?? 'simple';

        if ($tipo === 'textura' && !empty($variante['imagen_muestra'])) {
            $url = base_url($variante['imagen_muestra']);
            return "background-image: url('{$url}'); background-size: cover; background-position: center;";
        }

        $primario = $variante['color_primario'] ?: '#e5e7eb';

        if ($tipo === 'combinado' && !empty($variante['color_secundario'])) {
            $secundario = $variante['color_secundario'];
            return "background: linear-gradient(135deg, {$primario} 0%, {$primario} 50%, {$secundario} 50%, {$secundario} 100%);";
        }

        return "background-color: {$primario};";
    }
}
