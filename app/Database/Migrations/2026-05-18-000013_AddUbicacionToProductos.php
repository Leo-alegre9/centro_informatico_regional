<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUbicacionToProductos extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('productos', [
            'ubicacion' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
                'after'      => 'activo',
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('productos', 'ubicacion');
    }
}
