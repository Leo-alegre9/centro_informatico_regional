<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\AdminUserModel;
use App\Models\CategoriaModel;
use App\Models\ContactoMensajeModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $productoModel  = new ProductoModel();
        $totalProductos = $productoModel->where('activo', 1)->countAllResults();

        $adminModel  = new AdminUserModel();
        $totalAdmins = $adminModel->countAllResults();

        $catModel     = new CategoriaModel();
        $totalCats    = $catModel->where('activo', 1)->countAllResults();

        $msgModel     = new ContactoMensajeModel();
        $mensajesNuevos = $msgModel->countNoLeidos();

        return view('admin/dashboard', [
            'titulo'          => 'Dashboard | CIR Admin',
            'totalProductos'  => $totalProductos,
            'totalAdmins'     => $totalAdmins,
            'totalCats'       => $totalCats,
            'mensajesNuevos'  => $mensajesNuevos,
            'adminNombre'     => session()->get('admin_nombre'),
        ]);
    }
}
