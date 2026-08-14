<?php

namespace App\Models;

use CodeIgniter\Model;

class PresupuestoModel extends Model
{
    protected $table         = 'presupuestos';
    protected $allowedFields = [
        'numero', 'token', 'tipo', 'admin_user_id', 'cliente_nombre', 'cliente_telefono', 'cliente_email',
        'cliente_documento', 'fecha', 'valido_hasta', 'subtotal', 'descuento_tipo', 'descuento_valor',
        'descuento_monto', 'total', 'observaciones', 'condiciones', 'estado',
    ];
    protected $useTimestamps = true;

    public const ESTADOS = ['borrador', 'generado', 'enviado', 'aceptado', 'rechazado'];
    public const TIPOS   = ['presupuesto', 'listado'];

    /**
     * Recalcula subtotal, descuento y total a partir de las líneas y el descuento elegido.
     * Es la única fuente de verdad para los montos: el front solo replica esta cuenta para
     * feedback visual, pero lo que se guarda siempre sale de acá.
     *
     * @param array $items Cada uno con 'precio_unitario' y 'cantidad'.
     */
    public function calcularTotales(array $items, string $descuentoTipo, float $descuentoValor): array
    {
        $subtotal = 0.0;
        foreach ($items as $item) {
            $precio   = max(0, (float) ($item['precio_unitario'] ?? 0));
            $cantidad = max(1, (int) ($item['cantidad'] ?? 1));
            $subtotal += $precio * $cantidad;
        }

        if ($descuentoTipo === 'porcentaje') {
            $porcentaje      = min(100, max(0, $descuentoValor));
            $descuentoMonto  = $subtotal * ($porcentaje / 100);
        } else {
            $descuentoTipo  = 'monto';
            $descuentoMonto = max(0, $descuentoValor);
        }
        $descuentoMonto = min($descuentoMonto, $subtotal);
        $total          = $subtotal - $descuentoMonto;

        return [
            'subtotal'        => round($subtotal, 2),
            'descuento_tipo'  => $descuentoTipo,
            'descuento_monto' => round($descuentoMonto, 2),
            'total'           => round($total, 2),
        ];
    }

    /**
     * Crea el presupuesto + sus líneas en una transacción. El número y el token se generan
     * después del insert, a partir del id autoincremental, para que sean únicos sin necesidad
     * de locks.
     *
     * @return int|false Id del presupuesto creado, o false si falló la transacción.
     */
    public function crearConDetalles(array $cabecera, array $items)
    {
        $totales  = $this->calcularTotales($items, $cabecera['descuento_tipo'] ?? 'monto', (float) ($cabecera['descuento_valor'] ?? 0));
        $detalleM = new PresupuestoDetalleModel();

        $this->db->transStart();

        $id = $this->insert(array_merge($cabecera, $totales));

        if ($id) {
            $detalleM->insertBatch($this->prepararFilasDetalle((int) $id, $items));

            $prefijo = ($cabecera['tipo'] ?? 'presupuesto') === 'listado' ? 'LIST-' : 'PRES-';

            $this->update((int) $id, [
                'numero' => $prefijo . str_pad((string) $id, 6, '0', STR_PAD_LEFT),
                'token'  => bin2hex(random_bytes(20)),
            ]);
        }

        $this->db->transComplete();

        return $this->db->transStatus() ? (int) $id : false;
    }

    public function actualizarConDetalles(int $id, array $cabecera, array $items): bool
    {
        $totales  = $this->calcularTotales($items, $cabecera['descuento_tipo'] ?? 'monto', (float) ($cabecera['descuento_valor'] ?? 0));
        $detalleM = new PresupuestoDetalleModel();

        $this->db->transStart();

        $this->update($id, array_merge($cabecera, $totales));
        $detalleM->where('presupuesto_id', $id)->delete();
        $detalleM->insertBatch($this->prepararFilasDetalle($id, $items));

        $this->db->transComplete();

        return $this->db->transStatus();
    }

    private function prepararFilasDetalle(int $presupuestoId, array $items): array
    {
        $filas = [];
        $now   = date('Y-m-d H:i:s');

        foreach (array_values($items) as $orden => $item) {
            $precio   = max(0, (float) ($item['precio_unitario'] ?? 0));
            $cantidad = max(1, (int) ($item['cantidad'] ?? 1));

            $filas[] = [
                'presupuesto_id'   => $presupuestoId,
                'producto_id'      => !empty($item['producto_id']) ? (int) $item['producto_id'] : null,
                'producto_nombre'  => $item['producto_nombre'],
                'producto_codigo'  => $item['producto_codigo'] ?? null,
                'precio_unitario'  => $precio,
                'cantidad'         => $cantidad,
                'subtotal'         => round($precio * $cantidad, 2),
                'orden'            => $orden,
                'created_at'       => $now,
                'updated_at'       => $now,
            ];
        }

        return $filas;
    }

    public function getConDetalles(int $id): ?array
    {
        $presupuesto = $this->find($id);
        if (!$presupuesto) {
            return null;
        }

        $presupuesto['detalles'] = (new PresupuestoDetalleModel())->getByPresupuesto($id);

        return $presupuesto;
    }

    public function getByNumeroYToken(string $numero, string $token): ?array
    {
        $presupuesto = $this
            ->where('numero', $numero)
            ->where('token', $token)
            ->first();

        if (!$presupuesto) {
            return null;
        }

        $presupuesto['detalles'] = (new PresupuestoDetalleModel())->getByPresupuesto((int) $presupuesto['id']);

        return $presupuesto;
    }

    /**
     * @return array{resultados: array, pager: \CodeIgniter\Pager\Pager}
     */
    public function listar(array $filtros, int $porPagina = 20): array
    {
        $builder = $this
            ->select('presupuestos.*, (SELECT COUNT(*) FROM presupuesto_detalles pd WHERE pd.presupuesto_id = presupuestos.id) AS cantidad_items');

        if (!empty($filtros['estado'])) {
            $builder->where('estado', $filtros['estado']);
        }

        if (!empty($filtros['tipo'])) {
            $builder->where('tipo', $filtros['tipo']);
        }

        $q = trim((string) ($filtros['q'] ?? ''));
        if ($q !== '') {
            $builder->groupStart()
                ->like('numero', $q)
                ->orLike('cliente_nombre', $q)
                ->orLike('cliente_telefono', $q)
            ->groupEnd();
        }

        $resultados = $builder
            ->orderBy('id', 'DESC')
            ->paginate($porPagina, 'presupuestos');

        return ['resultados' => $resultados, 'pager' => $this->pager];
    }

    public function cambiarEstado(int $id, string $estado): bool
    {
        if (!in_array($estado, self::ESTADOS, true)) {
            return false;
        }

        return (bool) $this->update($id, ['estado' => $estado]);
    }
}
