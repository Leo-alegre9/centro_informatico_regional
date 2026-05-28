<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStockToProductos extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('productos', [
            'stock' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false,
                'default'    => 0,
                'after'      => 'ubicacion',
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('productos', 'stock');
    }
}
