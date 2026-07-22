<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductoColoresTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'producto_id' => ['type' => 'INT', 'unsigned' => true],
            'color_id'    => ['type' => 'INT', 'unsigned' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['producto_id', 'color_id']);
        $this->forge->addForeignKey('producto_id', 'productos', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('color_id', 'colores', 'id', '', 'CASCADE');
        $this->forge->createTable('producto_colores');
    }

    public function down(): void
    {
        $this->forge->dropTable('producto_colores');
    }
}
