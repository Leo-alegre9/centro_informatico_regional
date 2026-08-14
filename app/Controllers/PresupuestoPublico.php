<?php

namespace App\Controllers;

use App\Libraries\PresupuestoPdf;
use App\Models\CaracteristicaModel;
use App\Models\PresupuestoModel;
use App\Models\ProductoImagenModel;
use App\Models\ProductoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * Puntos de acceso público (sin login) a un presupuesto: una página HTML tipo catálogo,
 * una vista de detalle por producto (propia del presupuesto, no el catálogo del sitio),
 * y el PDF descargable — todos solo accesibles si coinciden número + token. Es el link
 * que se comparte por WhatsApp.
 */
class PresupuestoPublico extends BaseController
{
    /** Página pública tipo catálogo: fotos, precios y acceso al detalle de cada producto. */
    public function ver(string $numero, string $token)
    {
        $presupuesto = (new PresupuestoModel())->getByNumeroYToken($numero, $token);
        if (!$presupuesto) {
            throw PageNotFoundException::forPageNotFound();
        }

        $titulo = $presupuesto['tipo'] === 'listado'
            ? "Listado {$presupuesto['numero']} | Centro Informático Regional"
            : "Presupuesto {$presupuesto['numero']} | Centro Informático Regional";

        return view('presupuesto_publico', [
            'titulo'      => $titulo,
            'presupuesto' => $presupuesto,
        ]);
    }

    /**
     * Vista de detalle de UNA línea del presupuesto (no la ficha del catálogo público).
     * $detalleId es el id de presupuesto_detalles, no el de productos: así la línea que se
     * pide siempre pertenece al presupuesto ya validado por número+token, sin poder curiosear
     * otras líneas de otros presupuestos.
     */
    public function producto(string $numero, string $token, int $detalleId)
    {
        $presupuesto = (new PresupuestoModel())->getByNumeroYToken($numero, $token);
        if (!$presupuesto) {
            throw PageNotFoundException::forPageNotFound();
        }

        $detalle = null;
        foreach ($presupuesto['detalles'] as $d) {
            if ((int) $d['id'] === $detalleId) {
                $detalle = $d;
                break;
            }
        }
        if (!$detalle) {
            throw PageNotFoundException::forPageNotFound();
        }

        $producto        = null;
        $imagenes        = [];
        $caracteristicas = [];

        if (!empty($detalle['producto_id'])) {
            $producto = (new ProductoModel())->find((int) $detalle['producto_id']);
            if ($producto) {
                $imagenes        = (new ProductoImagenModel())->getByProducto((int) $detalle['producto_id']);
                $caracteristicas = (new CaracteristicaModel())->getByProducto((int) $detalle['producto_id']);
            }
        }

        return view('presupuesto_producto', [
            'titulo'          => $detalle['producto_nombre'] . ' | Centro Informático Regional',
            'presupuesto'     => $presupuesto,
            'detalle'         => $detalle,
            'producto'        => $producto,
            'imagenes'        => $imagenes,
            'caracteristicas' => $caracteristicas,
        ]);
    }

    public function pdf(string $numero, string $token)
    {
        $presupuesto = (new PresupuestoModel())->getByNumeroYToken($numero, $token);
        if (!$presupuesto) {
            throw PageNotFoundException::forPageNotFound();
        }

        $dompdf = PresupuestoPdf::render($presupuesto);

        return $this->response
            ->setContentType('application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $presupuesto['numero'] . '.pdf"')
            ->setBody($dompdf->output());
    }
}
