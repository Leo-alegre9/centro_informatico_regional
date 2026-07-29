<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Índice para acelerar el ordenamiento alfabético y las búsquedas por prefijo
 * de nombre en el catálogo público y el buscador del admin. No reemplaza ni
 * duplica los índices existentes (codigo y slug son UNIQUE; las FKs de
 * categoria_id/marca_id/fabrica_id/linea_id ya están indexadas por InnoDB).
 */
class AddNombreIndexToProductos extends Migration
{
    public function up(): void
    {
        $prefix = $this->db->DBPrefix;
        $this->db->query("ALTER TABLE {$prefix}productos ADD INDEX productos_nombre_index (nombre)");
    }

    public function down(): void
    {
        $prefix = $this->db->DBPrefix;
        $this->db->query("ALTER TABLE {$prefix}productos DROP INDEX productos_nombre_index");
    }
}
