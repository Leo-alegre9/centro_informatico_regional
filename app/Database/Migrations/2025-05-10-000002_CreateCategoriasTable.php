<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoriasTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'parent_id'   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'nivel'       => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true],
            'nombre'      => ['type' => 'VARCHAR', 'constraint' => 200],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'icono'       => ['type' => 'VARCHAR', 'constraint' => 80, 'default' => 'fas fa-tag'],
            'descripcion' => ['type' => 'TEXT', 'null' => true],
            'activo'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'orden'       => ['type' => 'SMALLINT', 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('nivel');
        $this->forge->addKey('activo');
        $this->forge->addKey(['parent_id', 'slug']);
        $this->forge->createTable('categorias');

        // Self-referential FK added after table creation
        $this->db->query('ALTER TABLE `categorias` ADD CONSTRAINT `fk_cat_parent` FOREIGN KEY (`parent_id`) REFERENCES `categorias`(`id`) ON DELETE SET NULL');
    }

    public function down(): void
    {
        $this->db->query('ALTER TABLE `categorias` DROP FOREIGN KEY `fk_cat_parent`');
        $this->forge->dropTable('categorias');
    }
}
