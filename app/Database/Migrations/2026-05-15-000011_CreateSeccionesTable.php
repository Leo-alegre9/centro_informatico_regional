<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSeccionesTable extends Migration
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
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'descripcion' => [
                'type'       => 'VARCHAR',
                'constraint' => 300,
                'null'       => true,
                'default'    => null,
            ],
            'icono' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'default'    => 'fas fa-eye',
            ],
            'activo' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'orden' => [
                'type'       => 'TINYINT',
                'constraint' => 3,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'updated_at' => ['type' => 'DATETIME', 'null' => true, 'default' => null],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('secciones');
    }

    public function down(): void
    {
        $this->forge->dropTable('secciones', true);
    }
}
