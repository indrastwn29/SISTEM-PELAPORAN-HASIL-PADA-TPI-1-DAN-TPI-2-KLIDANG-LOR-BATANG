<?php

namespace App\Models;

use CodeIgniter\Model;

class KarcisPemilikModel extends Model
{
    protected $table = 'karcis_pemilik'; // Sesuaikan dengan nama tabel Anda
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nomor_karcis', 'nama_nelayan', 'nama_kapal', 'jenis_ikan',
        'berat_ikan', 'daerah_tangkapan', 'harga_per_kg', 'total_harga',
        'status', 'tanggal_datang', 'created_at', 'updated_at'
    ];
    
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Validation
    protected $validationRules = [
        'nomor_karcis' => 'required|max_length[50]',
        'nama_nelayan' => 'required|max_length[100]',
        'jenis_ikan' => 'required|max_length[50]',
        'berat_ikan' => 'required|numeric',
        'harga_per_kg' => 'required|numeric'
    ];
    
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
    
    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];
}