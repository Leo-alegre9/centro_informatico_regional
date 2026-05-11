<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $this->call('CategoriasSeeder');

        $existe = $this->db->table('admin_users')
            ->where('email', 'admin@cir.com')
            ->countAllResults();

        if ($existe === 0) {
            $this->db->table('admin_users')->insert([
                'nombre'     => 'Administrador',
                'email'      => 'admin@cir.com',
                'password'   => password_hash('CIR@admin2025', PASSWORD_DEFAULT),
                'rol'        => 'superadmin',
                'activo'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
