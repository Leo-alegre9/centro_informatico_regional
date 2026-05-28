<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductoSeccionesTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'producto_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'seccion_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'activo' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'orden' => [
                'type'       => 'SMALLINT',
                'constraint' => 5,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'fecha_inicio' => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'fecha_fin'    => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'created_at'   => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true, 'default' => null],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['producto_id', 'seccion_id']);
        $this->forge->addKey('seccion_id');
        $this->forge->addForeignKey('producto_id', 'productos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('seccion_id', 'secciones', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('producto_secciones');
    }

    public function down(): void
    {
        $this->forge->dropTable('producto_secciones', true);
    }
}
