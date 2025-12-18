<?php

namespace App\Models;

use CodeIgniter\Model;

class PetugasModel extends Model
{
    protected $table = 'petugas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 
        'password', 
        'nama_lengkap', 
        'email', 
        'no_hp', 
        'role', 
        'tpi_id',
        'status'
    ];
    protected $useTimestamps = true;
    
    public function getPetugasById($id)
    {
        return $this->find($id);
    }
}