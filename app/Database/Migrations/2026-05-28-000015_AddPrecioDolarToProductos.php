<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPrecioDolarToProductos extends Migration
{
    public function up()
    {
        $this->forge->addColumn('productos', [
            'precio_dolar' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
                'after'      => 'precio_numero',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('productos', 'precio_dolar');
    }
}
