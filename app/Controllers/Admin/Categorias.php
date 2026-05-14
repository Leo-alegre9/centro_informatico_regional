<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;

class Categorias extends BaseController
{
    private CategoriaModel $model;

    public function __construct()
    {
        $this->model = new CategoriaModel();
    }

    public function index()
    {
        $all = $this->model->orderBy('nivel', 'ASC')->orderBy('orden', 'ASC')->findAll();
        $map = array_column($all, null, 'id');

        // Construir árbol: nivel1 → nivel2 → nivel3
        $tree = [];
        foreach ($all as $cat) {
            if ((int) $cat['nivel'] === 1) {
                $cat['children'] = [];
                $tree[$cat['id']] = $cat;
            }
        }
        foreach ($all as $cat) {
            if ((int) $cat['nivel'] === 2 && isset($tree[$cat['parent_id']])) {
                $cat['children'] = [];
                $tree[$cat['parent_id']]['children'][$cat['id']] = $cat;
            }
        }
        foreach ($all as $cat) {
            if ((int) $cat['nivel'] === 3) {
                $parent = $map[$cat['parent_id']] ?? null;
                if ($parent && isset($tree[$parent['parent_id']])) {
                    $tree[$parent['parent_id']]['children'][$cat['parent_id']]['children'][$cat['id']] = $cat;
                }
            }
        }

        return view('admin/categorias/index', [
            'titulo' => 'Gestión de Categorías | CIR Admin',
            'tree'   => $tree,
            'total'  => count($all),
        ]);
    }

    public function crear()
    {
        [$rubros, $cats2] = $this->getParentOptions();

        return view('admin/categorias/form', [
            'titulo'    => 'Nueva categoría | CIR Admin',
            'categoria' => null,
            'rubros'    => $rubros,
            'cats2'     => $cats2,
            'accion'    => base_url('admin/categorias/crear'),
        ]);
    }

    public function guardar()
    {
        $rules = [
            'nombre' => 'required|max_length[150]',
            'nivel'  => 'required|in_list[1,2,3]',
            'slug'   => 'required|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $parentId = (int) $this->request->getPost('parent_id');
        $nivel    = (int) $this->request->getPost('nivel');

        $this->model->insert([
            'parent_id'   => $nivel > 1 && $parentId > 0 ? $parentId : null,
            'nivel'       => $nivel,
            'nombre'      => $this->request->getPost('nombre'),
            'slug'        => $this->slugify($this->request->getPost('slug')),
            'icono'       => $this->request->getPost('icono') ?: 'fas fa-folder',
            'descripcion' => $this->request->getPost('descripcion'),
            'activo'      => 1,
            'orden'       => (int) $this->request->getPost('orden') ?: 0,
        ]);

        return redirect()->to(base_url('admin/categorias'))->with('success', 'Categoría creada correctamente.');
    }

    public function editar(int $id)
    {
        $categoria = $this->model->find($id);
        if (!$categoria) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        [$rubros, $cats2] = $this->getParentOptions();

        return view('admin/categorias/form', [
            'titulo'    => 'Editar categoría | CIR Admin',
            'categoria' => $categoria,
            'rubros'    => $rubros,
            'cats2'     => $cats2,
            'accion'    => base_url("admin/categorias/{$id}/editar"),
        ]);
    }

    public function actualizar(int $id)
    {
        $categoria = $this->model->find($id);
        if (!$categoria) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'nombre' => 'required|max_length[150]',
            'nivel'  => 'required|in_list[1,2,3]',
            'slug'   => 'required|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $parentId = (int) $this->request->getPost('parent_id');
        $nivel    = (int) $this->request->getPost('nivel');

        $this->model->update($id, [
            'parent_id'   => $nivel > 1 && $parentId > 0 ? $parentId : null,
            'nivel'       => $nivel,
            'nombre'      => $this->request->getPost('nombre'),
            'slug'        => $this->slugify($this->request->getPost('slug')),
            'icono'       => $this->request->getPost('icono') ?: 'fas fa-folder',
            'descripcion' => $this->request->getPost('descripcion'),
            'orden'       => (int) $this->request->getPost('orden') ?: 0,
        ]);

        return redirect()->to(base_url('admin/categorias'))->with('success', 'Categoría actualizada correctamente.');
    }

    public function eliminar(int $id)
    {
        $this->model->delete($id);
        return redirect()->to(base_url('admin/categorias'))->with('success', 'Categoría eliminada.');
    }

    public function toggleActivo(int $id)
    {
        $cat = $this->model->find($id);
        if ($cat) {
            $this->model->update($id, ['activo' => $cat['activo'] ? 0 : 1]);
        }
        return redirect()->to(base_url('admin/categorias'));
    }

    // ── Helpers privados ──────────────────────────────────────────────────────

    /** Devuelve [rubros_nivel1, cats_nivel2] con nombre del padre incluido en nivel2. */
    private function getParentOptions(): array
    {
        $all    = $this->model->orderBy('nivel', 'ASC')->orderBy('orden', 'ASC')->findAll();
        $map    = array_column($all, null, 'id');
        $rubros = [];
        $cats2  = [];

        foreach ($all as $c) {
            if ((int) $c['nivel'] === 1) {
                $rubros[] = $c;
            } elseif ((int) $c['nivel'] === 2) {
                $c['parent_nombre'] = $map[$c['parent_id']]['nombre'] ?? '?';
                $cats2[] = $c;
            }
        }

        return [$rubros, $cats2];
    }

    private function slugify(string $text): string
    {
        $text = mb_strtolower($text, 'UTF-8');
        $text = strtr($text, ['á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ñ' => 'n', 'ü' => 'u']);
        $text = preg_replace('/[^a-z0-9\-]/', '-', $text);
        $text = preg_replace('/-+/', '-', $text);
        return trim($text, '-');
    }
}
