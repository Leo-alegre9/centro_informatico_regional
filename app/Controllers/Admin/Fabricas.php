<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FabricaModel;

class Fabricas extends BaseController
{
    private FabricaModel $model;

    public function __construct()
    {
        $this->model = new FabricaModel();
    }

    public function index()
    {
        $fabricas = $this->model->orderBy('nombre', 'ASC')->findAll();

        return view('admin/fabricas/index', [
            'titulo'   => 'Gestión de Fábricas | CIR Admin',
            'fabricas' => $fabricas,
        ]);
    }

    public function crear()
    {
        return view('admin/fabricas/form', [
            'titulo'  => 'Nueva fábrica | CIR Admin',
            'fabrica' => null,
            'accion'  => base_url('admin/fabricas/crear'),
        ]);
    }

    public function guardar()
    {
        $rules = [
            'nombre' => 'required|max_length[150]',
            'slug'   => 'required|max_length[100]|is_unique[fabricas.slug]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'nombre' => $this->request->getPost('nombre'),
            'slug'   => $this->slugify($this->request->getPost('slug')),
            'activo' => 1,
        ]);

        return redirect()->to(base_url('admin/fabricas'))->with('success', 'Fábrica creada correctamente.');
    }

    public function editar(int $id)
    {
        $fabrica = $this->model->find($id);
        if (!$fabrica) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/fabricas/form', [
            'titulo'  => 'Editar fábrica | CIR Admin',
            'fabrica' => $fabrica,
            'accion'  => base_url("admin/fabricas/{$id}/editar"),
        ]);
    }

    public function actualizar(int $id)
    {
        $fabrica = $this->model->find($id);
        if (!$fabrica) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'nombre' => 'required|max_length[150]',
            'slug'   => "required|max_length[100]|is_unique[fabricas.slug,id,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'nombre' => $this->request->getPost('nombre'),
            'slug'   => $this->slugify($this->request->getPost('slug')),
        ]);

        return redirect()->to(base_url('admin/fabricas'))->with('success', 'Fábrica actualizada correctamente.');
    }

    public function eliminar(int $id)
    {
        $this->model->delete($id);
        return redirect()->to(base_url('admin/fabricas'))->with('success', 'Fábrica eliminada.');
    }

    private function slugify(string $text): string
    {
        $text = mb_strtolower($text, 'UTF-8');
        $text = strtr($text, ['á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','ñ'=>'n','ü'=>'u']);
        $text = preg_replace('/[^a-z0-9\-]/', '-', $text);
        $text = preg_replace('/-+/', '-', $text);
        return trim($text, '-');
    }
}
