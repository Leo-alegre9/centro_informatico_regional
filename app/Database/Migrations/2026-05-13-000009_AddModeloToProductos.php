<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddModeloToProductos extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('productos', [
            'modelo' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
                'default'    => null,
                'after'      => 'nombre',
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('productos', 'modelo');
    }
}
