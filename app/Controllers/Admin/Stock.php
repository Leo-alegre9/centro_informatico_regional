<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductoModel;

class Stock extends BaseController
{
    private ProductoModel $model;

    public function __construct()
    {
        $this->model = new ProductoModel();
    }

    public function index()
    {
        $q        = trim($this->request->getGet('q') ?? '');
        $productos = $q !== '' ? $this->model->buscarStock($q) : [];

        return view('admin/stock/index', [
            'titulo'    => 'Gestión de Stock | CIR Admin',
            'productos' => $productos,
            'q'         => $q,
        ]);
    }

    public function actualizar(int $id)
    {
        $producto = $this->model->find($id);

        if (!$producto) {
            return redirect()->to(base_url('admin/stock'))->with('error', 'Producto no encontrado.');
        }

        $nuevoStock = max(0, (int) $this->request->getPost('stock'));
        $this->model->update($id, ['stock' => $nuevoStock]);

        $q = trim($this->request->getPost('q') ?? '');
        $redirect = base_url('admin/stock') . ($q !== '' ? '?q=' . urlencode($q) : '');

        return redirect()->to($redirect)->with('success', "Stock de «{$producto['nombre']}» actualizado a {$nuevoStock} unidades.");
    }
}
