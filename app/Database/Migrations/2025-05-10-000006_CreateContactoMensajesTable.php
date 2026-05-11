<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContactoMensajesTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nombre'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'       => ['type' => 'VARCHAR', 'constraint' => 150],
            'asunto'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'mensaje'     => ['type' => 'TEXT'],
            'leido'       => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'ip_remota'   => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['leido', 'created_at']);
        $this->forge->createTable('contacto_mensajes');
    }

    public function down(): void
    {
        $this->forge->dropTable('contacto_mensajes');
    }
}
