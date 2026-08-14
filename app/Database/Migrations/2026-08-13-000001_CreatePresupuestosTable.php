<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePresupuestosTable extends Migration
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
            'numero' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'token' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
                'null'       => true,
            ],
            'admin_user_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,
            ],
            'cliente_nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'cliente_telefono' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
            ],
            'cliente_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'cliente_documento' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'fecha' => [
                'type' => 'DATE',
            ],
            'valido_hasta' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'subtotal' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0,
            ],
            'descuento_tipo' => [
                'type'       => 'ENUM',
                'constraint' => ['monto', 'porcentaje'],
                'default'    => 'monto',
            ],
            'descuento_valor' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0,
            ],
            'descuento_monto' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0,
            ],
            'total' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0,
            ],
            'observaciones' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'condiciones' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'estado' => [
                'type'       => 'ENUM',
                'constraint' => ['borrador', 'generado', 'enviado', 'aceptado', 'rechazado'],
                'default'    => 'borrador',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'updated_at' => ['type' => 'DATETIME', 'null' => true, 'default' => null],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('numero');
        $this->forge->addUniqueKey('token');
        $this->forge->addKey('admin_user_id');
        $this->forge->addKey('estado');
        $this->forge->addForeignKey('admin_user_id', 'admin_users', 'id', 'CASCADE', 'SET NULL');

        $this->forge->createTable('presupuestos');

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'presupuesto_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'producto_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,
            ],
            'producto_nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'producto_codigo' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'precio_unitario' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0,
            ],
            'cantidad' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'default'    => 1,
            ],
            'subtotal' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0,
            ],
            'orden' => [
                'type'       => 'SMALLINT',
                'constraint' => 5,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'updated_at' => ['type' => 'DATETIME', 'null' => true, 'default' => null],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('presupuesto_id');
        $this->forge->addKey('producto_id');
        $this->forge->addForeignKey('presupuesto_id', 'presupuestos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('producto_id', 'productos', 'id', 'CASCADE', 'SET NULL');

        $this->forge->createTable('presupuesto_detalles');
    }

    public function down(): void
    {
        $this->forge->dropTable('presupuesto_detalles', true);
        $this->forge->dropTable('presupuestos', true);
    }
}
