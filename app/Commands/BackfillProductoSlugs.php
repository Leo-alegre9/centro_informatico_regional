<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\ProductoModel;

/**
 * Genera el slug de los productos que todavía no tienen uno.
 * Uso: php spark productos:backfill-slugs
 */
class BackfillProductoSlugs extends BaseCommand
{
    protected $group       = 'App';
    protected $name        = 'productos:backfill-slugs';
    protected $description = 'Genera el slug de los productos existentes que aún no lo tienen.';

    public function run(array $params)
    {
        $model = new ProductoModel();

        $productos = $model->select('id, nombre, slug')
            ->groupStart()
                ->where('slug', null)
                ->orWhere('slug', '')
            ->groupEnd()
            ->findAll();

        if (empty($productos)) {
            CLI::write('No hay productos sin slug.', 'green');
            return;
        }

        foreach ($productos as $p) {
            $slug = $model->generarSlugUnico($p['nombre'], (int) $p['id']);
            $model->update($p['id'], ['slug' => $slug]);
            CLI::write("#{$p['id']} {$p['nombre']} -> {$slug}");
        }

        CLI::write(count($productos) . ' producto(s) actualizados.', 'green');
    }
}
