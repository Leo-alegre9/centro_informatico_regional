<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductoModel;

class Inventario extends BaseController
{
    private ProductoModel $model;

    public function __construct()
    {
        $this->model = new ProductoModel();
    }

    public function index(): string
    {
        $ubicacion = trim((string) $this->request->getGet('ubicacion'));
        $q         = trim((string) $this->request->getGet('q'));

        $productos = [];
        $buscando  = ($ubicacion !== '' || $q !== '');

        if ($buscando) {
            $productos = $this->model->buscarInventario($ubicacion, $q);
        }

        return view('admin/inventario/index', [
            'titulo'    => 'Inventario por ubicación | CIR Admin',
            'productos' => $productos,
            'ubicacion' => $ubicacion,
            'q'         => $q,
            'buscando'  => $buscando,
        ]);
    }
}
