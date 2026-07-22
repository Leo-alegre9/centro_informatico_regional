<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSlugToProductos extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('productos', [
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 220,
                'null'       => true,
                'default'    => null,
                'after'      => 'nombre',
            ],
        ]);

        $this->db->query('ALTER TABLE productos ADD UNIQUE KEY `productos_slug_unique` (`slug`)');
    }

    public function down(): void
    {
        $this->forge->dropColumn('productos', 'slug');
    }
}
