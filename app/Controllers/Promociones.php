<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\CategoriaModel;

class Promociones extends BaseController
{
    public function index(): string
    {
        $productoModel = new ProductoModel();
        $catModel      = new CategoriaModel();

        $productos = $productoModel->getBySeccion('carrusel_promo', 0);

        foreach ($productos as &$p) {
            $slugPath = $catModel->getSlugPath((int) $p['categoria_id']);
            $parts    = array_filter([
                $slugPath['rubro'],
                $slugPath['subrubro'],
                $slugPath['sub_subrubro'],
            ]);
            $p['catalog_url'] = base_url('catalogo/' . implode('/', $parts));
        }
        unset($p);

        return view('promociones', [
            'titulo'    => 'Promociones — Centro Informático Regional',
            'productos' => $productos,
        ]);
    }
}
