<?php

namespace App\Controllers;

use App\Models\ProductoModel;

class Home extends BaseController
{
    public function index(): string
    {
        $productoModel = new ProductoModel();

        $productosDestacados = $productoModel->getParaInicio();
        $productosOferta     = $productoModel->getBySeccion('carrusel_promo', 8);

        return view('inicio', [
            'productosDestacados' => $productosDestacados,
            'productosOferta'     => $productosOferta,
        ]);
    }
}
