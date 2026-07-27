<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLineasTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'fabrica_id' => ['type' => 'INT', 'unsigned' => true],
            'nombre'     => ['type' => 'VARCHAR', 'constraint' => 150],
            'slug'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'activo'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['fabrica_id', 'slug']);
        $this->forge->createTable('lineas');

        $prefix = $this->db->DBPrefix;
        $this->db->query("ALTER TABLE {$prefix}lineas ADD CONSTRAINT {$prefix}lineas_fabrica_id_foreign FOREIGN KEY (fabrica_id) REFERENCES {$prefix}fabricas (id) ON DELETE CASCADE");
    }

    public function down(): void
    {
        $this->forge->dropTable('lineas');
    }
}
