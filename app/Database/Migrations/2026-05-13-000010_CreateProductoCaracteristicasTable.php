<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductoCaracteristicasTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'producto_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'clave' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'valor' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
            ],
            'orden' => [
                'type'       => 'TINYINT',
                'constraint' => 3,
                'unsigned'   => true,
                'default'    => 0,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('producto_id');
        $this->forge->addForeignKey('producto_id', 'productos', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('producto_caracteristicas');
    }

    public function down(): void
    {
        $this->forge->dropTable('producto_caracteristicas', true);
    }
}
