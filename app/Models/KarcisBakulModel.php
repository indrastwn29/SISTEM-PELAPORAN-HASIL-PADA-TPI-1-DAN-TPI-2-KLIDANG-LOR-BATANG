<?php

namespace App\Models;

use CodeIgniter\Model;

class KarcisBakulModel extends Model
{
    protected $table = 'karcis_bakul';
    protected $primaryKey = 'id_bakul';
    
    // HANYA field yang ADA di database
    protected $allowedFields = [
        'nama_bakul',
        'alamat',
        'berat_ikan',
        'jumlah_karcis',
        'jumlah_pembelian',
        'jasa_lelang',
        'lain_lain',
        'total',
        'jumlah_bayar',
        'status_verifikasi'
        // TIDAK ADA: petugas_id, tanggal_input, created_at, updated_at
    ];
    
    protected $useTimestamps = false;
    protected $useSoftDeletes = false;
    
    public function insert($data = null, bool $returnID = true)
    {
        // HAPUS field yang tidak ada
        $fieldsToRemove = ['petugas_id', 'tanggal_input', 'created_at', 'updated_at'];
        foreach ($fieldsToRemove as $field) {
            if (isset($data[$field])) {
                unset($data[$field]);
            }
        }
        
        // Set default values
        if (!isset($data['status_verifikasi'])) {
            $data['status_verifikasi'] = 'pending';
        }
        
        if (!isset($data['jumlah_bayar']) && isset($data['total'])) {
            $data['jumlah_bayar'] = $data['total'];
        }
        
        return parent::insert($data, $returnID);
    }
    
    public function getTotalHariIni()
    {
        $today = date('Y-m-d');
        return $this->where('DATE(tanggal_input)', $today)->countAllResults();
    }
    
    public function getTotalPendapatanHariIni()
    {
        $today = date('Y-m-d');
        $result = $this->selectSum('total')
                      ->where('DATE(tanggal_input)', $today)
                      ->get()
                      ->getRow();
        return $result->total ?? 0;
    }
    
    public function getAllData()
    {
        return $this->orderBy('tanggal_input', 'DESC')->findAll();
    }
    
    // Method untuk debugging
    public function testInsert($data)
    {
        log_message('debug', 'Model testInsert called with data: ' . print_r($data, true));
        return $this->insert($data);
    }
}