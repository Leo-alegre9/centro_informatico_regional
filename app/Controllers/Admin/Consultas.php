<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ConsultaServicioModel;
use App\Models\ContactoMensajeModel;
use CodeIgniter\Model;

class Consultas extends BaseController
{
    private ConsultaServicioModel $servicioModel;
    private ContactoMensajeModel  $contactoModel;

    public function __construct()
    {
        $this->servicioModel = new ConsultaServicioModel();
        $this->contactoModel = new ContactoMensajeModel();
    }

    public function index()
    {
        $filtros = [
            'origen'   => $this->request->getGet('origen') ?? '',
            'tecnico'  => $this->request->getGet('tecnico') ?? '',
            'estado'   => $this->request->getGet('estado') ?? '',
            'urgencia' => $this->request->getGet('urgencia') ?? '',
        ];

        $consultas = $this->getConsultasUnificadas();

        foreach ($filtros as $campo => $valor) {
            if ($valor === '') {
                continue;
            }
            $consultas = array_filter($consultas, static function (array $c) use ($campo, $valor) {
                if ($campo === 'origen') {
                    return $c['origen'] === $valor;
                }
                return ($c[$campo] ?? '') === $valor;
            });
        }

        return view('admin/consultas/index', [
            'titulo'    => 'Consultas | CIR Admin',
            'consultas' => array_values($consultas),
            'stats'     => $this->getStatsUnificadas(),
            'filtros'   => $filtros,
        ]);
    }

    public function marcarVista(string $origen, int $id)
    {
        $model = $this->resolverModel($origen);
        if (!$model || !$model->find($id)) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'No encontrada']);
        }

        if ($origen === 'contacto') {
            $model->update($id, ['leido' => 1]);
        } else {
            $model->marcarVista($id);
        }

        return $this->response->setJSON(['ok' => true]);
    }

    public function marcarResuelta(string $origen, int $id)
    {
        $model = $this->resolverModel($origen);
        if (!$model || !$model->find($id)) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'No encontrada']);
        }

        if ($origen === 'contacto') {
            // Contacto no tiene estado "resuelta" propio: marcarla como leída cierra el ciclo.
            $model->update($id, ['leido' => 1]);
        } else {
            $model->marcarResuelta($id);
        }

        return $this->response->setJSON(['ok' => true]);
    }

    public function eliminar(string $origen, int $id)
    {
        $model = $this->resolverModel($origen);
        if (!$model || !$model->find($id)) {
            return redirect()->to(base_url('admin/consultas'))->with('error', 'La consulta no existe.');
        }

        $model->delete($id);

        return redirect()->to(base_url('admin/consultas'))->with('success', 'Consulta eliminada correctamente.');
    }

    // ─── helpers privados ─────────────────────────────────────────────────────

    private function resolverModel(string $origen): ?Model
    {
        return match ($origen) {
            'servicio_tecnico' => $this->servicioModel,
            'contacto'          => $this->contactoModel,
            default             => null,
        };
    }

    /** Junta consultas de servicio técnico y mensajes de contacto en una sola lista, ordenada por fecha. */
    private function getConsultasUnificadas(): array
    {
        $filas = [];

        foreach ($this->servicioModel->orderBy('created_at', 'DESC')->findAll() as $c) {
            $c['origen'] = 'servicio_tecnico';
            $filas[]     = $c;
        }

        foreach ($this->contactoModel->orderBy('created_at', 'DESC')->findAll() as $m) {
            $m['origen'] = 'contacto';
            $m['estado'] = $m['leido'] ? 'vista' : 'nueva';
            $filas[]     = $m;
        }

        usort($filas, static fn (array $a, array $b) => strcmp($b['created_at'], $a['created_at']));

        return $filas;
    }

    private function getStatsUnificadas(): array
    {
        $statsServicio = $this->servicioModel->getStats();
        $hoy    = date('Y-m-d');
        $semana = date('Y-m-d', strtotime('-7 days'));

        return [
            'total'       => $statsServicio['total'] + $this->contactoModel->countAll(),
            'sin_leer'    => $statsServicio['sin_leer'] + $this->contactoModel->where('leido', 0)->countAllResults(),
            'hoy'         => $statsServicio['hoy'] + $this->contactoModel->where("DATE(created_at) = '{$hoy}'")->countAllResults(),
            'esta_semana' => $statsServicio['esta_semana'] + $this->contactoModel->where('created_at >=', $semana . ' 00:00:00')->countAllResults(),
        ];
    }
}
