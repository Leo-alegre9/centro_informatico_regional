<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTipoToPresupuestos extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('presupuestos', [
            'tipo' => [
                'type'       => 'ENUM',
                'constraint' => ['presupuesto', 'listado'],
                'default'    => 'presupuesto',
                'null'       => false,
                'after'      => 'token',
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('presupuestos', 'tipo');
    }
}
