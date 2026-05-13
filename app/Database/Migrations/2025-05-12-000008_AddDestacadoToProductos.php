<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDestacadoToProductos extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('productos', [
            'destacado' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'activo',
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('productos', 'destacado');
    }
}
