<?php

namespace App\Controllers;

use App\Models\ConsultaServicioModel;

class ConsultaServicio extends BaseController
{
    public function guardar()
    {
        if (strtoupper($this->request->getMethod()) !== 'POST') {
            return $this->response->setStatusCode(405)->setJSON(['error' => 'Método no permitido']);
        }

        $nombre   = trim($this->request->getPost('nombre_cliente') ?? '');
        $equipo   = trim($this->request->getPost('tipo_equipo') ?? '');
        $problema = trim($this->request->getPost('descripcion_problema') ?? '');
        $tecnico  = trim($this->request->getPost('tecnico_contactado') ?? '');

        if (!$nombre || !$equipo || !$problema || !$tecnico) {
            return $this->response->setStatusCode(422)->setJSON(['error' => 'Datos incompletos']);
        }

        $model = new ConsultaServicioModel();
        $id    = $model->insert([
            'nombre_cliente'       => $nombre,
            'tipo_equipo'          => $equipo,
            'marca_modelo'         => $this->request->getPost('marca_modelo') ?: null,
            'descripcion_problema' => $problema,
            'urgencia'             => $this->request->getPost('urgencia') ?: 'Sin urgencia particular',
            'tecnico_contactado'   => $tecnico,
            'numero_tecnico'       => $this->request->getPost('numero_tecnico') ?? '',
            'ip_cliente'           => $this->request->getIPAddress(),
            'estado'               => 'nueva',
        ]);

        return $this->response->setJSON(['ok' => true, 'id' => $id]);
    }
}
