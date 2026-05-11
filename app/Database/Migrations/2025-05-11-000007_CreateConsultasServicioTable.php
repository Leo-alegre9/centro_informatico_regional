<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConsultasServicioTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'                  => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nombre_cliente'      => ['type' => 'VARCHAR', 'constraint' => 200],
            'tipo_equipo'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'marca_modelo'        => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'descripcion_problema'=> ['type' => 'TEXT'],
            'urgencia'            => ['type' => 'VARCHAR', 'constraint' => 100, 'default' => 'Sin urgencia particular'],
            'tecnico_contactado'  => ['type' => 'VARCHAR', 'constraint' => 100],
            'numero_tecnico'      => ['type' => 'VARCHAR', 'constraint' => 30],
            'ip_cliente'          => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'estado'              => ['type' => 'ENUM', 'constraint' => ['nueva', 'vista', 'resuelta'], 'default' => 'nueva'],
            'created_at'          => ['type' => 'DATETIME', 'null' => true],
            'updated_at'          => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['estado', 'created_at']);
        $this->forge->createTable('consultas_servicio');
    }

    public function down(): void
    {
        $this->forge->dropTable('consultas_servicio');
    }
}
