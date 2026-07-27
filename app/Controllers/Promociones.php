<?php

namespace App\Controllers;

use App\Models\ProductoModel;

class Promociones extends BaseController
{
    public function index(): string
    {
        $productoModel = new ProductoModel();

        $productos = $productoModel->getBySeccion('carrusel_promo', 0);

        return view('promociones', [
            'titulo'    => 'Promociones — Centro Informático Regional',
            'productos' => $productos,
        ]);
    }
}
