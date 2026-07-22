<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\ProductoModel;
use App\Models\ProductoImagenModel;
use App\Models\CategoriaModel;
use App\Models\ColorModel;
use App\Models\CaracteristicaModel;

class Producto extends BaseController
{
    public function detalle(string $slugOrId): string
    {
        $productoModel = new ProductoModel();
        $producto       = $productoModel->getBySlugOrId($slugOrId);

        if (!$producto) {
            throw PageNotFoundException::forPageNotFound();
        }

        $imgModel    = new ProductoImagenModel();
        $colorModel  = new ColorModel();
        $caractModel = new CaracteristicaModel();

        $imagenes       = $imgModel->getByProducto((int) $producto['id']);
        $colores        = $colorModel->getByProducto((int) $producto['id']);
        $caracteristicas = $caractModel->getByProducto((int) $producto['id']);

        $catModel   = new CategoriaModel();
        $breadcrumb = $this->buildBreadcrumb($catModel, (int) $producto['categoria_id'], $producto['nombre']);

        $urlProducto = current_url();
        $mensajeWa   = 'Hola, quiero consultar por el producto: ' . $producto['nombre'] . '. ' . $urlProducto;
        $waHref      = 'https://wa.me/5493704616482?text=' . rawurlencode($mensajeWa);

        return view('producto_detalle', [
            'titulo'          => $producto['nombre'] . ' | Centro Informático Regional',
            'metaDescripcion' => $producto['descripcion_corta'] ?? '',
            'producto'        => $producto,
            'imagenes'        => $imagenes,
            'colores'         => $colores,
            'caracteristicas' => $caracteristicas,
            'breadcrumb'      => $breadcrumb,
            'urlProducto'     => $urlProducto,
            'waHref'          => $waHref,
        ]);
    }

    /** Arma el breadcrumb Inicio / Catálogo / Rubro / Subrubro / Sub-subrubro / Producto. */
    private function buildBreadcrumb(CategoriaModel $catModel, int $categoriaId, string $nombreProducto): array
    {
        $map = $catModel->getCategoriaMap();

        $cadena = [];
        $actual = $map[$categoriaId] ?? null;
        while ($actual) {
            array_unshift($cadena, $actual);
            $actual = $actual['parent_id'] ? ($map[$actual['parent_id']] ?? null) : null;
        }

        $breadcrumb = [
            ['nombre' => 'Inicio',   'url' => base_url()],
            ['nombre' => 'Catálogo', 'url' => base_url('catalogo')],
        ];

        $path = 'catalogo';
        foreach ($cadena as $cat) {
            $path         .= '/' . $cat['slug'];
            $breadcrumb[]  = ['nombre' => $cat['nombre'], 'url' => base_url($path)];
        }

        $breadcrumb[] = ['nombre' => $nombreProducto, 'url' => null];

        return $breadcrumb;
    }
}
