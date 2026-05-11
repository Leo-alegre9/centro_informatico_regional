<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductosTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'categoria_id'      => ['type' => 'INT', 'unsigned' => true],
            'marca_id'          => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'nombre'            => ['type' => 'VARCHAR', 'constraint' => 200],
            'descripcion_corta' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'descripcion'       => ['type' => 'TEXT', 'null' => true],
            'precio_texto'      => ['type' => 'VARCHAR', 'constraint' => 100, 'default' => 'Consultar precio'],
            'precio_numero'     => ['type' => 'DECIMAL', 'constraint' => '12,2', 'unsigned' => true, 'null' => true],
            'badge'             => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => ''],
            'icono'             => ['type' => 'VARCHAR', 'constraint' => 80, 'default' => 'fas fa-box'],
            'activo'            => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'orden'             => ['type' => 'SMALLINT', 'default' => 0],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['activo', 'orden']);
        $this->forge->addKey('precio_numero');
        $this->forge->addForeignKey('categoria_id', 'categorias', 'id', '', 'RESTRICT');
        $this->forge->addForeignKey('marca_id', 'marcas', 'id', '', 'SET NULL');
        $this->forge->createTable('productos');
    }

    public function down(): void
    {
        $this->forge->dropTable('productos');
    }
}
