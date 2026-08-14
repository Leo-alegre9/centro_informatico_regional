<?php
/**
 * Helpers para armar enlaces de WhatsApp (wa.me), reutilizando el mismo criterio
 * de números que ya usa el sitio público (54 + 9 + código de área + número).
 */

if (!function_exists('normalizar_telefono_ar')) {
    /**
     * Normaliza un teléfono argentino al formato que espera wa.me (549 + código de área + número,
     * todo junto sin separadores). No modifica el valor original guardado en el presupuesto —
     * esto solo se usa al armar el link de WhatsApp.
     *
     * Contempla los formatos habituales que puede tipear el personal:
     *   3794123456           -> 5493794123456
     *   3794 123456          -> 5493794123456
     *   +54 9 3794 123456    -> 5493794123456
     *   03794 123456         -> 5493794123456  (0 de prefijo de larga distancia)
     */
    function normalizar_telefono_ar(string $telefono): string
    {
        $digitos = preg_replace('/\D+/', '', $telefono) ?? '';

        if ($digitos === '') {
            return '';
        }

        // Ya viene en formato internacional completo (54 + 9 + área + número).
        if (str_starts_with($digitos, '549')) {
            return $digitos;
        }

        // Trae el código de país pero le falta el 9 de móvil.
        if (str_starts_with($digitos, '54')) {
            return '549' . ltrim(substr($digitos, 2), '0');
        }

        // Número local: puede venir con el 0 de larga distancia (ej: 03794 123456) — se descarta.
        return '549' . ltrim($digitos, '0');
    }
}

if (!function_exists('wa_link')) {
    function wa_link(string $telefono, string $mensaje): string
    {
        $numero = normalizar_telefono_ar($telefono);

        return 'https://wa.me/' . $numero . '?text=' . rawurlencode($mensaje);
    }
}
