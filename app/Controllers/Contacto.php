<?php

namespace App\Controllers;

class Contacto extends BaseController
{
    public function index(): string
    {
        return view('contacto', ['titulo' => 'Contacto | Centro Informático Regional']);
    }

    public function enviar(): \CodeIgniter\HTTP\RedirectResponse
    {
        $rules = [
            'nombre'  => 'required|min_length[3]|max_length[100]',
            'email'   => 'required|valid_email',
            'asunto'  => 'required|in_list[servicio-tecnico,consulta-producto,presupuesto,otro]',
            'mensaje' => 'required|min_length[10]|max_length[1000]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new \App\Models\ContactoMensajeModel();
        $model->insert([
            'nombre'    => $this->request->getPost('nombre'),
            'email'     => $this->request->getPost('email'),
            'asunto'    => $this->request->getPost('asunto'),
            'mensaje'   => $this->request->getPost('mensaje'),
            'ip_remota' => $this->request->getIPAddress(),
            'created_at'=> date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('contacto'))->with('success', '¡Tu mensaje fue enviado correctamente! Nos pondremos en contacto a la brevedad.');
    }
}
