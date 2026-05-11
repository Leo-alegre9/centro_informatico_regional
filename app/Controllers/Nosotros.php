<?php

namespace App\Controllers;

class Nosotros extends BaseController
{
    public function index(): string
    {
        return view('nosotros', ['titulo' => 'Quiénes Somos | Centro Informático Regional']);
    }
}
