<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminUserModel extends Model
{
    protected $table         = 'admin_users';
    protected $allowedFields = ['nombre', 'email', 'password', 'rol', 'ultimo_acceso', 'activo'];
    protected $useTimestamps = true;

    public function verifyLogin(string $email, string $password): ?array
    {
        $row = $this->where('email', $email)->first();

        if ($row && password_verify($password, $row['password'])) {
            return $row;
        }

        return null;
    }
}
