<?php

namespace App\Models;

use CodeIgniter\Model;

class PresupuestoDetalleModel extends Model
{
    protected $table         = 'presupuesto_detalles';
    protected $allowedFields = [
        'presupuesto_id', 'producto_id', 'producto_nombre', 'producto_codigo',
        'precio_unitario', 'cantidad', 'subtotal', 'orden',
    ];
    protected $useTimestamps = true;

    /**
     * Trae las líneas del presupuesto junto con la imagen principal actual del producto
     * (si todavía existe y sigue teniendo una), resuelta con el mismo join que ya usa
     * ProductoModel::buscarGlobal() — una sola consulta, sin N+1.
     */
    public function getByPresupuesto(int $presupuestoId): array
    {
        return $this
            ->select('presupuesto_detalles.*, pi.ruta AS imagen_ruta')
            ->join('producto_imagenes pi', 'pi.producto_id = presupuesto_detalles.producto_id AND pi.es_principal = 1', 'left')
            ->where('presupuesto_detalles.presupuesto_id', $presupuestoId)
            ->orderBy('orden', 'ASC')
            ->orderBy('presupuesto_detalles.id', 'ASC')
            ->findAll();
    }
}
