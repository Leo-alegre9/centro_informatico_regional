<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MarcaModel;

class Marcas extends BaseController
{
    private MarcaModel $model;

    public function __construct()
    {
        $this->model = new MarcaModel();
    }

    public function index()
    {
        $marcas = $this->model->orderBy('nombre', 'ASC')->findAll();

        return view('admin/marcas/index', [
            'titulo' => 'Gestión de Marcas | CIR Admin',
            'marcas' => $marcas,
        ]);
    }

    public function crear()
    {
        return view('admin/marcas/form', [
            'titulo' => 'Nueva marca | CIR Admin',
            'marca'  => null,
            'accion' => base_url('admin/marcas/crear'),
        ]);
    }

    public function guardar()
    {
        $rules = [
            'nombre' => 'required|max_length[150]',
            'slug'   => 'required|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->insert([
            'nombre'    => $this->request->getPost('nombre'),
            'slug'      => $this->slugify($this->request->getPost('slug')),
            'logo_url'  => $this->request->getPost('logo_url'),
            'sitio_web' => $this->request->getPost('sitio_web'),
            'activo'    => 1,
        ]);

        return redirect()->to(base_url('admin/marcas'))->with('success', 'Marca creada correctamente.');
    }

    public function editar(int $id)
    {
        $marca = $this->model->find($id);
        if (!$marca) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/marcas/form', [
            'titulo' => 'Editar marca | CIR Admin',
            'marca'  => $marca,
            'accion' => base_url("admin/marcas/{$id}/editar"),
        ]);
    }

    public function actualizar(int $id)
    {
        $marca = $this->model->find($id);
        if (!$marca) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'nombre' => 'required|max_length[150]',
            'slug'   => 'required|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'nombre'    => $this->request->getPost('nombre'),
            'slug'      => $this->slugify($this->request->getPost('slug')),
            'logo_url'  => $this->request->getPost('logo_url'),
            'sitio_web' => $this->request->getPost('sitio_web'),
        ]);

        return redirect()->to(base_url('admin/marcas'))->with('success', 'Marca actualizada correctamente.');
    }

    public function eliminar(int $id)
    {
        $this->model->delete($id);
        return redirect()->to(base_url('admin/marcas'))->with('success', 'Marca eliminada.');
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
