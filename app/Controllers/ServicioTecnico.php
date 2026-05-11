<?php

namespace App\Controllers;

class ServicioTecnico extends BaseController
{
    public function index(): string
    {
        return view('servicio_tecnico', [
            'titulo' => 'Servicio Técnico | Centro Informático Regional',
        ]);
    }
}
