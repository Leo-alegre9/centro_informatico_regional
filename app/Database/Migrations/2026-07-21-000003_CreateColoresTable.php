<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateColoresTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nombre'     => ['type' => 'VARCHAR', 'constraint' => 60],
            'hex'        => ['type' => 'VARCHAR', 'constraint' => 7, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nombre');
        $this->forge->createTable('colores');
    }

    public function down(): void
    {
        $this->forge->dropTable('colores');
    }
}
