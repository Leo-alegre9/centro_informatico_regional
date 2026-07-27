<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LineaModel;
use App\Models\FabricaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Lineas extends BaseController
{
    private LineaModel   $model;
    private FabricaModel $fabricaModel;

    public function __construct()
    {
        $this->model        = new LineaModel();
        $this->fabricaModel = new FabricaModel();
    }

    public function index(int $fabricaId)
    {
        $fabrica = $this->obtenerFabrica($fabricaId);

        return view('admin/lineas/index', [
            'titulo'  => 'Líneas de ' . $fabrica['nombre'] . ' | CIR Admin',
            'fabrica' => $fabrica,
            'lineas'  => $this->model->getByFabrica($fabricaId),
        ]);
    }

    public function crear(int $fabricaId)
    {
        $fabrica = $this->obtenerFabrica($fabricaId);

        return view('admin/lineas/form', [
            'titulo'  => 'Nueva línea | CIR Admin',
            'fabrica' => $fabrica,
            'linea'   => null,
            'accion'  => base_url("admin/fabricas/{$fabricaId}/lineas/crear"),
        ]);
    }

    public function guardar(int $fabricaId)
    {
        $fabrica = $this->obtenerFabrica($fabricaId);

        $rules = [
            'nombre' => 'required|max_length[150]',
            'slug'   => 'required|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $slug = $this->slugify($this->request->getPost('slug'));
        if ($this->model->where('fabrica_id', $fabricaId)->where('slug', $slug)->first()) {
            return redirect()->back()->withInput()->with('errors', ['Ya existe una línea con ese slug para esta fábrica.']);
        }

        $this->model->insert([
            'fabrica_id' => $fabricaId,
            'nombre'     => $this->request->getPost('nombre'),
            'slug'       => $slug,
            'activo'     => 1,
        ]);

        return redirect()->to(base_url("admin/fabricas/{$fabricaId}/lineas"))->with('success', 'Línea creada correctamente.');
    }

    public function editar(int $fabricaId, int $id)
    {
        $fabrica = $this->obtenerFabrica($fabricaId);
        $linea   = $this->obtenerLinea($fabricaId, $id);

        return view('admin/lineas/form', [
            'titulo'  => 'Editar línea | CIR Admin',
            'fabrica' => $fabrica,
            'linea'   => $linea,
            'accion'  => base_url("admin/fabricas/{$fabricaId}/lineas/{$id}/editar"),
        ]);
    }

    public function actualizar(int $fabricaId, int $id)
    {
        $fabrica = $this->obtenerFabrica($fabricaId);
        $this->obtenerLinea($fabricaId, $id);

        $rules = [
            'nombre' => 'required|max_length[150]',
            'slug'   => 'required|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $slug = $this->slugify($this->request->getPost('slug'));
        if ($this->model->where('fabrica_id', $fabricaId)->where('slug', $slug)->where('id !=', $id)->first()) {
            return redirect()->back()->withInput()->with('errors', ['Ya existe una línea con ese slug para esta fábrica.']);
        }

        $this->model->update($id, [
            'nombre' => $this->request->getPost('nombre'),
            'slug'   => $slug,
            'activo' => $this->request->getPost('activo') ? 1 : 0,
        ]);

        return redirect()->to(base_url("admin/fabricas/{$fabricaId}/lineas"))->with('success', 'Línea actualizada correctamente.');
    }

    public function eliminar(int $fabricaId, int $id)
    {
        $this->obtenerFabrica($fabricaId);
        $this->obtenerLinea($fabricaId, $id);

        $this->model->delete($id);

        return redirect()->to(base_url("admin/fabricas/{$fabricaId}/lineas"))->with('success', 'Línea eliminada.');
    }

    private function obtenerFabrica(int $fabricaId): array
    {
        $fabrica = $this->fabricaModel->find($fabricaId);
        if (!$fabrica) {
            throw PageNotFoundException::forPageNotFound();
        }
        return $fabrica;
    }

    private function obtenerLinea(int $fabricaId, int $id): array
    {
        $linea = $this->model->find($id);
        if (!$linea || (int) $linea['fabrica_id'] !== $fabricaId) {
            throw PageNotFoundException::forPageNotFound();
        }
        return $linea;
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
