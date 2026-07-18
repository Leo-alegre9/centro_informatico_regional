<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUrlFabricanteToProductos extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('productos', [
            'url_fabricante' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
                'default'    => null,
                'after'      => 'descripcion',
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('productos', 'url_fabricante');
    }
}
