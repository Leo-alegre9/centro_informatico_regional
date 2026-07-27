<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPrecioInternoToProductos extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('productos', [
            'precio_interno' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
                'after'      => 'precio_dolar',
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('productos', 'precio_interno');
    }
}
