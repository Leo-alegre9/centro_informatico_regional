<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotasTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'autor'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'contenido'  => ['type' => 'TEXT'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('created_at');
        $this->forge->createTable('notas');
    }

    public function down(): void
    {
        $this->forge->dropTable('notas');
    }
}
