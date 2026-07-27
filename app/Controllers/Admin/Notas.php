<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\NotaModel;

class Notas extends BaseController
{
    private NotaModel $model;

    public function __construct()
    {
        $this->model = new NotaModel();
    }

    public function index()
    {
        return view('admin/notas/index', [
            'titulo' => 'Notas | CIR Admin',
            'notas'  => $this->model->getAll(),
        ]);
    }

    public function guardar()
    {
        $rules = [
            'autor'     => 'required|max_length[100]',
            'contenido' => 'required|max_length[2000]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('admin/notas'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'autor'     => $this->request->getPost('autor'),
            'contenido' => $this->request->getPost('contenido'),
        ]);

        return redirect()->to(base_url('admin/notas'))->with('success', 'Nota agregada correctamente.');
    }

    public function eliminar(int $id)
    {
        $nota = $this->model->find($id);

        if (!$nota) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->model->delete($id);

        return redirect()->to(base_url('admin/notas'))->with('success', 'Nota eliminada.');
    }
}
