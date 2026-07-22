<?php

namespace App\Models;

use CodeIgniter\Model;

class CaracteristicaModel extends Model
{
    protected $table         = 'producto_caracteristicas';
    protected $allowedFields = ['producto_id', 'clave', 'valor', 'orden'];

    /** Características de un producto, ordenadas para mostrar en la ficha. */
    public function getByProducto(int $productoId): array
    {
        return $this
            ->where('producto_id', $productoId)
            ->orderBy('orden', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();
    }

    /**
     * Reemplaza completamente las características de un producto.
     * $filas es un array de ['clave' => ..., 'valor' => ...].
     */
    public function sincronizarProducto(int $productoId, array $filas): void
    {
        $this->where('producto_id', $productoId)->delete();

        $rows = [];
        $orden = 0;
        foreach ($filas as $fila) {
            $clave = trim($fila['clave'] ?? '');
            $valor = trim($fila['valor'] ?? '');
            if ($clave === '' || $valor === '') {
                continue;
            }
            $rows[] = [
                'producto_id' => $productoId,
                'clave'       => $clave,
                'valor'       => $valor,
                'orden'       => $orden++,
            ];
        }

        if (!empty($rows)) {
            $this->insertBatch($rows);
        }
    }
}
