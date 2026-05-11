<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminUserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/dashboard'));
        }

        return view('admin/login', ['titulo' => 'Iniciar sesión | CIR Admin']);
    }

    public function doLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Por favor, completá todos los campos correctamente.');
        }

        $model = new AdminUserModel();
        $user  = $model->verifyLogin(
            $this->request->getPost('email'),
            $this->request->getPost('password')
        );

        if ($user) {
            session()->set([
                'admin_logged_in' => true,
                'admin_id'        => $user['id'],
                'admin_nombre'    => $user['nombre'],
            ]);
            return redirect()->to(base_url('admin/dashboard'));
        }

        return redirect()->back()->with('error', 'Email o contraseña incorrectos.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('admin/login'));
    }
}
