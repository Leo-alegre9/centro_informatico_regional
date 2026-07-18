<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\CategoriaModel;

class Home extends BaseController
{
    public function index(): string
    {
        $productoModel = new ProductoModel();
        $catModel      = new CategoriaModel();

        $productosDestacados = $productoModel->getParaInicio();
        $productosOferta     = $productoModel->getBySeccion('carrusel_promo', 8);

        foreach ($productosDestacados as &$p) {
            $slugPath = $catModel->getSlugPath((int) $p['categoria_id']);
            $parts    = array_filter([
                $slugPath['rubro'],
                $slugPath['subrubro'],
                $slugPath['sub_subrubro'],
            ]);
            $p['catalog_url'] = base_url('catalogo/' . implode('/', $parts));
        }
        unset($p);

        foreach ($productosOferta as &$p) {
            $slugPath = $catModel->getSlugPath((int) $p['categoria_id']);
            $parts    = array_filter([
                $slugPath['rubro'],
                $slugPath['subrubro'],
                $slugPath['sub_subrubro'],
            ]);
            $p['catalog_url'] = base_url('catalogo/' . implode('/', $parts));
        }
        unset($p);

        return view('inicio', [
            'productosDestacados' => $productosDestacados,
            'productosOferta'     => $productosOferta,
        ]);
    }
}
