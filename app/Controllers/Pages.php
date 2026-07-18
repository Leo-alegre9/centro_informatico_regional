<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function politicaPrivacidad(): string
    {
        return view('legal/politica_privacidad', [
            'titulo' => 'Política de Privacidad | Centro Informático Regional',
        ]);
    }

    public function condicionesServicio(): string
    {
        return view('legal/condiciones_servicio', [
            'titulo' => 'Condiciones del Servicio | Centro Informático Regional',
        ]);
    }
}
