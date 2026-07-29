<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\ProductoModel;

/**
 * Carga productos de prueba (prefijo "PRUEBA - ") con marcas/fábricas/líneas/rubros
 * y precios variados, para poder verificar visualmente que los chips de filtro del
 * catálogo (rubro, subrubro, marca, fábrica, línea, etiqueta y precio) se generan
 * correctamente cuando hay diversidad de datos.
 *
 * Ejecutar:   php spark db:seed PruebaFiltrosSeeder
 * Eliminar:   DELETE FROM productos WHERE nombre LIKE 'PRUEBA - %';
 *             (o php spark db:seed PruebaFiltrosSeeder -- se puede volver a correr,
 *             usa is_unique en el código así que no duplica si ya están cargados)
 */
class PruebaFiltrosSeeder extends Seeder
{
    public function run(): void
    {
        $model = new ProductoModel();

        $productos = [
            // Rubro Muebles > Hogar — fábrica Richezze, varias líneas
            ['codigo' => 'PRUEBA-001', 'nombre' => 'PRUEBA - Placard Tana Piú',      'categoria_id' => 12, 'marca_id' => null, 'fabrica_id' => 1, 'linea_id' => 2,  'precio_texto' => '$150.000', 'precio_numero' => 150000, 'badge' => 'Oferta', 'stock' => 5],
            ['codigo' => 'PRUEBA-002', 'nombre' => 'PRUEBA - Ropero Murano',         'categoria_id' => 12, 'marca_id' => null, 'fabrica_id' => 1, 'linea_id' => 3,  'precio_texto' => '$320.000', 'precio_numero' => 320000, 'badge' => '',       'stock' => 3],
            ['codigo' => 'PRUEBA-005', 'nombre' => 'PRUEBA - Mesa Lugano',           'categoria_id' => 12, 'marca_id' => null, 'fabrica_id' => 1, 'linea_id' => 7,  'precio_texto' => '$210.000', 'precio_numero' => 210000, 'badge' => 'Oferta', 'stock' => 0],
            ['codigo' => 'PRUEBA-006', 'nombre' => 'PRUEBA - Sillón Leggero',        'categoria_id' => 12, 'marca_id' => null, 'fabrica_id' => 1, 'linea_id' => 6,  'precio_texto' => '$580.000', 'precio_numero' => 580000, 'badge' => '',       'stock' => 2],
            // Rubro Muebles > Oficina — mezcla de fábricas
            ['codigo' => 'PRUEBA-003', 'nombre' => 'PRUEBA - Escritorio Trio',       'categoria_id' => 11, 'marca_id' => null, 'fabrica_id' => 1, 'linea_id' => 11, 'precio_texto' => '$95.000',  'precio_numero' => 95000,  'badge' => 'Nuevo',  'stock' => 8],
            ['codigo' => 'PRUEBA-004', 'nombre' => 'PRUEBA - Silla Piro Ejecutiva',  'categoria_id' => 11, 'marca_id' => 1,    'fabrica_id' => 2, 'linea_id' => null, 'precio_texto' => '$45.000', 'precio_numero' => 45000,  'badge' => '',       'stock' => 12],
            // Otros rubros, para ver el chip de Rubro en el catálogo general
            ['codigo' => 'PRUEBA-007', 'nombre' => 'PRUEBA - Monitor LED 24"',       'categoria_id' => 7,  'marca_id' => null, 'fabrica_id' => null, 'linea_id' => null, 'precio_texto' => '$180.000', 'precio_numero' => 180000, 'badge' => 'Nuevo', 'stock' => 15],
            ['codigo' => 'PRUEBA-008', 'nombre' => 'PRUEBA - Heladera No Frost 300L','categoria_id' => 13, 'marca_id' => null, 'fabrica_id' => null, 'linea_id' => null, 'precio_texto' => '$650.000', 'precio_numero' => 650000, 'badge' => '',      'stock' => 4],
        ];

        foreach ($productos as $p) {
            if ($model->where('codigo', $p['codigo'])->first()) {
                continue; // ya cargado, no duplicar
            }

            $model->insert([
                'categoria_id'      => $p['categoria_id'],
                'marca_id'          => $p['marca_id'],
                'fabrica_id'        => $p['fabrica_id'],
                'linea_id'          => $p['linea_id'],
                'codigo'            => $p['codigo'],
                'nombre'            => $p['nombre'],
                'slug'              => $model->generarSlugUnico($p['nombre']),
                'descripcion_corta' => 'Producto de prueba para verificar los filtros del catálogo.',
                'precio_texto'      => $p['precio_texto'],
                'precio_numero'     => $p['precio_numero'],
                'badge'             => $p['badge'],
                'icono'             => 'fas fa-box',
                'activo'            => 1,
                'destacado'         => 0,
                'orden'             => 0,
                'stock'             => $p['stock'],
                'unidad_medida'     => 'cm',
            ]);
        }
    }
}
