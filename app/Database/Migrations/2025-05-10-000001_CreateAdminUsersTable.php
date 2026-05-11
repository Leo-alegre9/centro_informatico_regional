<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdminUsersTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nombre'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 150],
            'password'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'rol'           => ['type' => 'ENUM', 'constraint' => ['superadmin', 'editor'], 'default' => 'editor'],
            'ultimo_acceso' => ['type' => 'DATETIME', 'null' => true],
            'activo'        => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('admin_users');
    }

    public function down(): void
    {
        $this->forge->dropTable('admin_users');
    }
}
