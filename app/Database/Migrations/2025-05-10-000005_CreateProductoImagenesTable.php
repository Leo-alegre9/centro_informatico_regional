<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductoImagenesTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'producto_id'  => ['type' => 'INT', 'unsigned' => true],
            'ruta'         => ['type' => 'VARCHAR', 'constraint' => 500],
            'alt_text'     => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'es_principal' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'orden'        => ['type' => 'SMALLINT', 'default' => 0],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['producto_id', 'es_principal']);
        $this->forge->addForeignKey('producto_id', 'productos', 'id', '', 'CASCADE');
        $this->forge->createTable('producto_imagenes');
    }

    public function down(): void
    {
        $this->forge->dropTable('producto_imagenes');
    }
}
