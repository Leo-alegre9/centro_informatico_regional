<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\PresupuestoPdf;
use App\Models\PresupuestoModel;
use App\Models\ProductoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Presupuestos extends BaseController
{
    private PresupuestoModel $model;

    public function __construct()
    {
        $this->model = new PresupuestoModel();
    }

    public function index()
    {
        $filtros = [
            'estado' => $this->request->getGet('estado') ?? '',
            'tipo'   => $this->request->getGet('tipo') ?? '',
            'q'      => $this->request->getGet('q') ?? '',
        ];

        $listado = $this->model->listar($filtros, 20);

        return view('admin/presupuestos/index', [
            'titulo'      => 'Presupuestos | CIR Admin',
            'presupuestos' => $listado['resultados'],
            'filtros'      => $filtros,
            'paginaActual' => $listado['pager']->getCurrentPage('presupuestos'),
            'totalPaginas' => $listado['pager']->getPageCount('presupuestos'),
            'baseParams'   => array_filter($filtros),
        ]);
    }

    public function crear()
    {
        $tipo = $this->request->getGet('tipo');
        $tipo = in_array($tipo, PresupuestoModel::TIPOS, true) ? $tipo : 'presupuesto';

        return view('admin/presupuestos/form', [
            'titulo'      => 'Nuevo presupuesto | CIR Admin',
            'presupuesto' => null,
            'tipoInicial' => $tipo,
            'accion'      => base_url('admin/presupuestos/crear'),
        ]);
    }

    public function guardar()
    {
        $items = $this->decodificarItems();

        $rules = [
            'cliente_nombre'   => 'required|max_length[150]',
            'cliente_telefono' => 'required|max_length[30]',
            'cliente_email'    => 'permit_empty|valid_email|max_length[150]',
            'valido_hasta'     => 'permit_empty|valid_date',
            'descuento_tipo'   => 'permit_empty|in_list[monto,porcentaje]',
            'descuento_valor'  => 'permit_empty|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules) || empty($items)) {
            $errores = $this->validator->getErrors();
            if (empty($items)) {
                $errores['items'] = 'Agregá al menos un producto al presupuesto.';
            }
            return redirect()->back()->withInput()->with('errors', $errores);
        }

        $id = $this->model->crearConDetalles($this->armarCabecera(), $items);

        if (!$id) {
            return redirect()->back()->withInput()->with('errors', ['general' => 'No se pudo guardar el presupuesto.']);
        }

        return redirect()->to(base_url("admin/presupuestos/{$id}/ver"))->with('success', 'Presupuesto creado correctamente.');
    }

    public function editar(int $id)
    {
        $presupuesto = $this->model->getConDetalles($id);
        if (!$presupuesto) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('admin/presupuestos/form', [
            'titulo'      => 'Editar presupuesto | CIR Admin',
            'presupuesto' => $presupuesto,
            'tipoInicial' => $presupuesto['tipo'],
            'accion'      => base_url("admin/presupuestos/{$id}/editar"),
        ]);
    }

    public function actualizar(int $id)
    {
        if (!$this->model->find($id)) {
            throw PageNotFoundException::forPageNotFound();
        }

        $items = $this->decodificarItems();

        $rules = [
            'cliente_nombre'   => 'required|max_length[150]',
            'cliente_telefono' => 'required|max_length[30]',
            'cliente_email'    => 'permit_empty|valid_email|max_length[150]',
            'valido_hasta'     => 'permit_empty|valid_date',
            'descuento_tipo'   => 'permit_empty|in_list[monto,porcentaje]',
            'descuento_valor'  => 'permit_empty|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules) || empty($items)) {
            $errores = $this->validator->getErrors();
            if (empty($items)) {
                $errores['items'] = 'Agregá al menos un producto al presupuesto.';
            }
            return redirect()->back()->withInput()->with('errors', $errores);
        }

        $cabecera = $this->armarCabecera();
        unset($cabecera['fecha']); // no se pisa la fecha original de creación

        $this->model->actualizarConDetalles($id, $cabecera, $items);

        return redirect()->to(base_url("admin/presupuestos/{$id}/ver"))->with('success', 'Presupuesto actualizado correctamente.');
    }

    public function ver(int $id)
    {
        $presupuesto = $this->model->getConDetalles($id);
        if (!$presupuesto) {
            throw PageNotFoundException::forPageNotFound();
        }

        helper('whatsapp');
        $urlPublica = base_url("presupuesto/{$presupuesto['numero']}/{$presupuesto['token']}");

        if ($presupuesto['tipo'] === 'listado') {
            $mensaje = "Hola {$presupuesto['cliente_nombre']}, te compartimos un listado de opciones de Centro Informático Regional. "
                . "Presupuesto N° {$presupuesto['numero']}. "
                . 'Podés ver los productos y sus precios acá: ' . $urlPublica;
        } else {
            $mensaje = "Hola {$presupuesto['cliente_nombre']}, te enviamos el presupuesto solicitado de Centro Informático Regional. "
                . "Presupuesto N° {$presupuesto['numero']}. Total: $" . number_format((float) $presupuesto['total'], 0, ',', '.') . '. '
                . 'Podés verlo y descargarlo acá: ' . $urlPublica;
        }

        return view('admin/presupuestos/ver', [
            'titulo'      => "Presupuesto {$presupuesto['numero']} | CIR Admin",
            'presupuesto' => $presupuesto,
            'urlPublica'  => $urlPublica,
            'waHref'      => wa_link($presupuesto['cliente_telefono'], $mensaje),
            'estados'     => PresupuestoModel::ESTADOS,
        ]);
    }

    public function pdf(int $id)
    {
        $presupuesto = $this->model->getConDetalles($id);
        if (!$presupuesto) {
            throw PageNotFoundException::forPageNotFound();
        }

        $dompdf = PresupuestoPdf::render($presupuesto);

        return $this->response
            ->setContentType('application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $presupuesto['numero'] . '.pdf"')
            ->setBody($dompdf->output());
    }

    public function cambiarEstado(int $id)
    {
        $estado = (string) $this->request->getPost('estado');

        if (!$this->model->find($id) || !$this->model->cambiarEstado($id, $estado)) {
            return redirect()->back()->with('errors', ['estado' => 'Estado inválido.']);
        }

        return redirect()->back()->with('success', 'Estado actualizado.');
    }

    public function eliminar(int $id)
    {
        if (!$this->model->find($id)) {
            throw PageNotFoundException::forPageNotFound();
        }

        $this->model->delete($id);

        return redirect()->to(base_url('admin/presupuestos'))->with('success', 'Presupuesto eliminado.');
    }

    /** Endpoint AJAX que alimenta el buscador de productos del formulario. */
    public function buscarProductosJson()
    {
        $q = trim((string) $this->request->getGet('q'));
        if ($q === '') {
            return $this->response->setJSON([]);
        }

        $productos = (new ProductoModel())->buscarGlobal($q, 20);

        $resultado = array_map(fn (array $p): array => [
            'id'             => (int) $p['id'],
            'nombre'         => $p['nombre'],
            'codigo'         => $p['codigo'] ?? '',
            'precio'         => $this->precioInicial($p),
            'precio_interno' => (float) ($p['precio_interno'] ?? 0),
            'precio_texto'   => $p['precio_texto'] ?? '',
            'marca'          => $p['marca_nombre'] ?? '',
            'stock'          => (int) ($p['stock'] ?? 0),
            'imagen'         => !empty($p['imagen_ruta']) ? base_url($p['imagen_ruta']) : null,
        ], $productos);

        return $this->response->setJSON($resultado);
    }

    /**
     * Precio con el que se precarga un producto al agregarlo a un presupuesto/listado.
     * Prioriza el precio interno (el que se carga a mano en la ficha del producto para
     * uso del administrador) por sobre el precio público, ya que suele ser el precio real
     * de cotización. precio_numero es 0/null en productos viejos que nunca pasaron por el
     * recálculo de cotización (quedó solo precio_texto cargado a mano); en ese caso se lo
     * extrae de precio_texto para no ofrecer $0 como precio inicial.
     */
    private function precioInicial(array $producto): float
    {
        $interno = (float) ($producto['precio_interno'] ?? 0);
        if ($interno > 0) {
            return $interno;
        }

        $numero = (float) ($producto['precio_numero'] ?? 0);
        if ($numero > 0) {
            return $numero;
        }

        $texto = (string) ($producto['precio_texto'] ?? '');
        if (!preg_match('/([0-9]{1,3}(?:\.[0-9]{3})*|[0-9]+)(,[0-9]+)?/', $texto, $m)) {
            return 0;
        }

        $entero  = str_replace('.', '', $m[1]);
        $decimal = isset($m[2]) ? str_replace(',', '.', $m[2]) : '';
        $valor   = $entero . $decimal;

        return is_numeric($valor) ? (float) $valor : 0;
    }

    private function decodificarItems(): array
    {
        $json  = $this->request->getPost('items_json') ?? '[]';
        $items = json_decode($json, true);

        if (!is_array($items)) {
            return [];
        }

        $limpios = [];
        foreach ($items as $item) {
            $nombre = trim((string) ($item['producto_nombre'] ?? ''));
            if ($nombre === '') {
                continue;
            }
            $limpios[] = [
                'producto_id'     => !empty($item['producto_id']) ? (int) $item['producto_id'] : null,
                'producto_nombre' => $nombre,
                'producto_codigo' => $item['producto_codigo'] ?? null,
                'precio_unitario' => max(0, (float) ($item['precio_unitario'] ?? 0)),
                'cantidad'        => max(1, (int) ($item['cantidad'] ?? 1)),
            ];
        }

        return $limpios;
    }

    private function armarCabecera(): array
    {
        $tipo = (string) $this->request->getPost('tipo');
        $tipo = in_array($tipo, PresupuestoModel::TIPOS, true) ? $tipo : 'presupuesto';

        return [
            'tipo'              => $tipo,
            'admin_user_id'     => session()->get('admin_id'),
            'cliente_nombre'    => $this->request->getPost('cliente_nombre'),
            'cliente_telefono'  => $this->request->getPost('cliente_telefono'),
            'cliente_email'     => $this->request->getPost('cliente_email') ?: null,
            'cliente_documento' => $this->request->getPost('cliente_documento') ?: null,
            'fecha'             => date('Y-m-d'),
            'valido_hasta'      => $this->request->getPost('valido_hasta') ?: null,
            'descuento_tipo'    => $this->request->getPost('descuento_tipo') ?: 'monto',
            'descuento_valor'   => (float) str_replace(',', '.', (string) ($this->request->getPost('descuento_valor') ?: '0')),
            'observaciones'     => $this->request->getPost('observaciones') ?: null,
            'condiciones'       => $this->request->getPost('condiciones') ?: null,
        ];
    }
}
