<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductoColorVariantesTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'producto_id'      => ['type' => 'INT', 'unsigned' => true],
            'nombre'           => ['type' => 'VARCHAR', 'constraint' => 150],
            'tipo'             => ['type' => 'ENUM', 'constraint' => ['simple', 'combinado', 'textura'], 'default' => 'simple'],
            'color_primario'   => ['type' => 'VARCHAR', 'constraint' => 7, 'null' => true],
            'color_secundario' => ['type' => 'VARCHAR', 'constraint' => 7, 'null' => true],
            'imagen_muestra'   => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'orden'            => ['type' => 'SMALLINT', 'default' => 0],
            'activo'           => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['producto_id', 'activo', 'orden']);
        $this->forge->addForeignKey('producto_id', 'productos', 'id', '', 'CASCADE');
        $this->forge->createTable('producto_color_variantes');
    }

    public function down(): void
    {
        $this->forge->dropTable('producto_color_variantes');
    }
}
