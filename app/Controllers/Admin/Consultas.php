<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ConsultaServicioModel;

class Consultas extends BaseController
{
    private ConsultaServicioModel $model;

    public function __construct()
    {
        $this->model = new ConsultaServicioModel();
    }

    public function index()
    {
        $filtros = [
            'tecnico'  => $this->request->getGet('tecnico') ?? '',
            'estado'   => $this->request->getGet('estado') ?? '',
            'urgencia' => $this->request->getGet('urgencia') ?? '',
        ];

        return view('admin/consultas/index', [
            'titulo'     => 'Consultas de Servicio | CIR Admin',
            'consultas'  => $this->model->getAll(array_filter($filtros)),
            'stats'      => $this->model->getStats(),
            'filtros'    => $filtros,
        ]);
    }

    public function marcarVista(int $id)
    {
        $consulta = $this->model->find($id);
        if (!$consulta) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'No encontrada']);
        }
        $this->model->marcarVista($id);
        return $this->response->setJSON(['ok' => true]);
    }

    public function marcarResuelta(int $id)
    {
        $consulta = $this->model->find($id);
        if (!$consulta) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'No encontrada']);
        }
        $this->model->marcarResuelta($id);
        return $this->response->setJSON(['ok' => true]);
    }
}
