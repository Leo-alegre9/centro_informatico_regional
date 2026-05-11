<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactoMensajeModel extends Model
{
    protected $table         = 'contacto_mensajes';
    protected $allowedFields = ['nombre', 'email', 'asunto', 'mensaje', 'leido', 'ip_remota'];
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function countNoLeidos(): int
    {
        return $this->where('leido', 0)->countAllResults();
    }
}
