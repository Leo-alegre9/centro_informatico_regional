<?php

namespace App\Libraries;

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Arma el PDF de un presupuesto. Centralizado acá porque tanto el PDF protegido
 * del panel admin como el PDF público (compartido por WhatsApp) generan exactamente
 * el mismo documento a partir de los mismos datos.
 */
class PresupuestoPdf
{
    public static function render(array $presupuesto): Dompdf
    {
        foreach ($presupuesto['detalles'] as &$detalle) {
            $detalle['imagen_base64'] = !empty($detalle['imagen_ruta'])
                ? self::imagenBase64($detalle['imagen_ruta'])
                : null;
        }
        unset($detalle);

        $html = view('admin/presupuestos/pdf', [
            'presupuesto' => $presupuesto,
            'logoBase64'  => self::imagenBase64('assets/img/logo_cir_nuevo.png'),
        ]);

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf;
    }

    /**
     * Convierte una imagen del disco (ruta relativa a public/, tal como se guarda en
     * producto_imagenes.ruta) a un data URI Base64. Dompdf corre con isRemoteEnabled=false
     * por seguridad, así que no puede pedir imágenes por URL: necesita el archivo local vía
     * FCPATH, que resuelve el framework en cualquier entorno (localhost u Hostinger), nunca
     * una ruta absoluta fija de esta PC.
     */
    private static function imagenBase64(string $rutaRelativa): ?string
    {
        $ruta = FCPATH . ltrim($rutaRelativa, '/');
        if (!is_file($ruta)) {
            return null;
        }

        $info = @getimagesize($ruta);
        if (!$info || empty($info['mime'])) {
            return null;
        }

        return 'data:' . $info['mime'] . ';base64,' . base64_encode(file_get_contents($ruta));
    }
}
