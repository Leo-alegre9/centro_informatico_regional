<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ConfiguracionModel;
use App\Models\ProductoModel;

class Configuracion extends BaseController
{
    private ConfiguracionModel $configModel;
    private ProductoModel      $productoModel;

    public function __construct()
    {
        $this->configModel   = new ConfiguracionModel();
        $this->productoModel = new ProductoModel();
    }

    public function index()
    {
        $config = $this->configModel->getAll();

        // Productos con precio en dólares para la tabla de vista previa
        $productosConDolar = $this->productoModel
            ->select('id, nombre, modelo, precio_dolar, precio_numero, precio_texto')
            ->where('precio_dolar IS NOT NULL')
            ->where('precio_dolar >', 0)
            ->orderBy('nombre', 'ASC')
            ->findAll();

        return view('admin/configuracion/index', [
            'titulo'              => 'Configuración de precios | CIR Admin',
            'cotizacion_dolar'    => (float) ($config['cotizacion_dolar']    ?? 0),
            'porcentaje_ganancia' => (float) ($config['porcentaje_ganancia'] ?? 0),
            'productosConDolar'   => $productosConDolar,
        ]);
    }

    public function guardar()
    {
        $rules = [
            'cotizacion_dolar'    => 'required|numeric|greater_than_equal_to[0]',
            'porcentaje_ganancia' => 'required|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $cotizacion = (float) str_replace(',', '.', $this->request->getPost('cotizacion_dolar'));
        $porcentaje = (float) str_replace(',', '.', $this->request->getPost('porcentaje_ganancia'));

        $this->configModel->guardarClave('cotizacion_dolar',    (string) $cotizacion);
        $this->configModel->guardarClave('porcentaje_ganancia', (string) $porcentaje);

        $actualizados = $this->recalcularPrecios($cotizacion, $porcentaje);

        $msg = 'Configuración guardada correctamente.';
        if ($actualizados > 0) {
            $msg .= " Se actualizaron los precios de {$actualizados} producto(s).";
        }

        return redirect()->to(base_url('admin/configuracion'))->with('success', $msg);
    }

    private function recalcularPrecios(float $cotizacion, float $porcentaje): int
    {
        if ($cotizacion <= 0) {
            return 0;
        }

        $productos = $this->productoModel
            ->where('precio_dolar IS NOT NULL')
            ->where('precio_dolar >', 0)
            ->findAll();

        foreach ($productos as $p) {
            $precioFinal = $p['precio_dolar'] * $cotizacion * (1 + $porcentaje / 100);

            $this->productoModel->update((int) $p['id'], [
                'precio_numero' => round($precioFinal, 2),
                'precio_texto'  => '$' . number_format(round($precioFinal), 0, ',', '.'),
            ]);
        }

        return count($productos);
    }
}
