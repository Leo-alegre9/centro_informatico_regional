<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLineaIdToProductos extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('productos', [
            'linea_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
                'after'      => 'fabrica_id',
            ],
        ]);

        $prefix = $this->db->DBPrefix;
        $this->db->query("ALTER TABLE {$prefix}productos ADD CONSTRAINT {$prefix}productos_linea_id_foreign FOREIGN KEY (linea_id) REFERENCES {$prefix}lineas (id) ON DELETE SET NULL");
    }

    public function down(): void
    {
        $prefix = $this->db->DBPrefix;
        $this->db->query("ALTER TABLE {$prefix}productos DROP FOREIGN KEY {$prefix}productos_linea_id_foreign");
        $this->forge->dropColumn('productos', 'linea_id');
    }
}
