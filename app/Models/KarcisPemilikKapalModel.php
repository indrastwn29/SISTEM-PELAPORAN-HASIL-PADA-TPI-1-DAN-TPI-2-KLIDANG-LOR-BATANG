<?php

namespace App\Models;

use CodeIgniter\Model;

class KarcisPemilikKapalModel extends Model
{
    // ==================== KONFIGURASI DASAR ====================
    protected $table = 'karcis_pemilik_kapal';
    protected $primaryKey = 'id';
    
    // ==================== ALLOWED FIELDS SESUAI DATABASE ====================
    protected $allowedFields = [
        'no_karcis',
        'nama_pemilik',
        'nama_kapal',
        'tanggal',
        'jenis_ikan',
        'berat',
        'harga',
        'status_verifikasi',
        'petugas_id',
        'admin_id',
        'created_at' // TAMBAHKAN karena ada di database
    ];
    
    // ==================== AKTIFKAN TIMESTAMPS ====================
    // Karena ada created_at di database, gunakan timestamps
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = null; // Tidak ada updated_at
    protected $useSoftDeletes = false;
    
    // ==================== METHOD INSERT ====================
    public function insert($data = null, bool $returnID = true)
    {
        // Set default values jika tidak ada
        if (!isset($data['status_verifikasi'])) {
            $data['status_verifikasi'] = 'pending';
        }
        
        if (!isset($data['tanggal']) || empty($data['tanggal'])) {
            $data['tanggal'] = date('Y-m-d');
        }
        
        // Generate no_karcis jika tidak ada
        if (!isset($data['no_karcis']) || empty($data['no_karcis'])) {
            $data['no_karcis'] = $this->generateNoKarcis();
        }
        
        return parent::insert($data, $returnID);
    }
    
    // ==================== METHOD GETTER ====================
    public function getPendingVerification()
    {
        return $this->where('status_verifikasi', 'pending')
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }
    
    public function getApproved()
    {
        return $this->where('status_verifikasi', 'approved')
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }
    
    public function getRejected()
    {
        return $this->where('status_verifikasi', 'rejected')
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }
    
    public function getTotalHariIni($petugas_id = null)
    {
        $today = date('Y-m-d');
        $builder = $this->where('DATE(created_at)', $today);
        
        if ($petugas_id) {
            $builder->where('petugas_id', $petugas_id);
        }
        
        return $builder->countAllResults();
    }
    
    public function getTotalPendapatanHariIni($petugas_id = null)
    {
        $today = date('Y-m-d');
        $builder = $this->selectSum('harga')
                       ->where('DATE(created_at)', $today);
        
        if ($petugas_id) {
            $builder->where('petugas_id', $petugas_id);
        }
        
        $result = $builder->get()->getRow();
        return $result->harga ?? 0;
    }
    
    public function getAllData($petugas_id = null)
    {
        $builder = $this->orderBy('created_at', 'DESC');
        
        if ($petugas_id) {
            $builder->where('petugas_id', $petugas_id);
        }
        
        return $builder->findAll();
    }
    
    public function generateNoKarcis()
    {
        $prefix = 'KPL';
        $year = date('y');
        $month = date('m');
        
        // Hitung nomor urut hari ini
        $today = date('Y-m-d');
        $count = $this->where('DATE(created_at)', $today)->countAllResults();
        $sequence = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        
        return $prefix . $year . $month . $sequence;
    }
}