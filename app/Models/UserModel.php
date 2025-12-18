<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // PERUBAHAN: Ubah table dari 'petugas' menjadi 'users'
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'username', 
        'password', 
        'nama_lengkap', 
        'email', 
        'no_hp', 
        'role', 
        'status'
    ];

    // Get user by username
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
    
    // Cek field yang ada di tabel users Anda
    public function getTableFields()
    {
        return $this->db->getFieldNames($this->table);
    }
}