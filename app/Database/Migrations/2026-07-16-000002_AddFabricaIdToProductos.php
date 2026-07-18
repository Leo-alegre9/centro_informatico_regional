<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFabricaIdToProductos extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('productos', [
            'fabrica_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
                'after'      => 'marca_id',
            ],
        ]);

        $prefix = $this->db->DBPrefix;
        $this->db->query("ALTER TABLE {$prefix}productos ADD CONSTRAINT {$prefix}productos_fabrica_id_foreign FOREIGN KEY (fabrica_id) REFERENCES {$prefix}fabricas (id) ON DELETE SET NULL");
    }

    public function down(): void
    {
        $prefix = $this->db->DBPrefix;
        $this->db->query("ALTER TABLE {$prefix}productos DROP FOREIGN KEY {$prefix}productos_fabrica_id_foreign");
        $this->forge->dropColumn('productos', 'fabrica_id');
    }
}
