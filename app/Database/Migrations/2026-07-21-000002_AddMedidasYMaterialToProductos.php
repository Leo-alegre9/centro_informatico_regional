<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMedidasYMaterialToProductos extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('productos', [
            'ancho' => [
                'type'       => 'DECIMAL',
                'constraint' => '8,2',
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
                'after'      => 'stock',
            ],
            'alto' => [
                'type'       => 'DECIMAL',
                'constraint' => '8,2',
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
                'after'      => 'ancho',
            ],
            'profundidad' => [
                'type'       => 'DECIMAL',
                'constraint' => '8,2',
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
                'after'      => 'alto',
            ],
            'unidad_medida' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
                'default'    => 'cm',
                'after'      => 'profundidad',
            ],
            'material' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
                'default'    => null,
                'after'      => 'unidad_medida',
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('productos', ['ancho', 'alto', 'profundidad', 'unidad_medida', 'material']);
    }
}
