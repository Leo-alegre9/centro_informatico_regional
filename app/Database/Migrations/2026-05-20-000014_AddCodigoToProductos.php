<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCodigoToProductos extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('productos', [
            'codigo' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'default'    => null,
                'after'      => 'id',
            ],
        ]);

        $this->db->query('ALTER TABLE productos ADD UNIQUE KEY `productos_codigo_unique` (`codigo`)');
    }

    public function down(): void
    {
        $this->forge->dropColumn('productos', 'codigo');
    }
}
