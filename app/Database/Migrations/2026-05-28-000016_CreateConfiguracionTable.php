<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConfiguracionTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'clave' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'valor' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('clave');
        $this->forge->createTable('configuracion');

        $this->db->table('configuracion')->insertBatch([
            ['clave' => 'cotizacion_dolar',    'valor' => '0'],
            ['clave' => 'porcentaje_ganancia', 'valor' => '0'],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('configuracion');
    }
}
