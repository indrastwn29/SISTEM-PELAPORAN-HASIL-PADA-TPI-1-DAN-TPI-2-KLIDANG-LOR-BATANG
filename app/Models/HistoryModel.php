<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoryModel extends Model
{
    protected $table = 'history_input';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'karcis_id',
        'no_karcis',
        'jenis',
        'nama',
        'nama_kapal',
        'jenis_ikan',
        'berat',
        'harga',
        'petugas_id',
        'tpi_id',
        'action',
        'timestamp'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Get history by petugas with filters
    public function getHistoryByPetugas($petugas_id, $tpi_id, $jenis, $period = 'all', $start_date = null, $end_date = null)
    {
        $builder = $this->where('petugas_id', $petugas_id)
                        ->where('tpi_id', $tpi_id);
        
        if ($jenis != 'all') {
            $builder->where('jenis', $jenis);
        }
        
        // Apply period filter
        $this->applyPeriodFilter($builder, $period, $start_date, $end_date);
        
        // Order by latest first
        $builder->orderBy('timestamp', 'DESC');
        
        return $builder->findAll();
    }
    
    // Get total by type
    public function getTotalByType($petugas_id, $tpi_id, $jenis, $period = 'all', $start_date = null, $end_date = null)
    {
        $builder = $this->where('petugas_id', $petugas_id)
                        ->where('tpi_id', $tpi_id)
                        ->where('jenis', $jenis)
                        ->where('action', 'input'); // Only count inputs
        
        // Apply period filter
        $this->applyPeriodFilter($builder, $period, $start_date, $end_date);
        
        return $builder->countAllResults();
    }
    
    // Get history for export
    public function getHistoryForExport($petugas_id, $tpi_id, $jenis, $period = 'all', $start_date = null, $end_date = null)
    {
        $builder = $this->where('petugas_id', $petugas_id)
                        ->where('tpi_id', $tpi_id);
        
        if ($jenis != 'all') {
            $builder->where('jenis', $jenis);
        }
        
        // Apply period filter
        $this->applyPeriodFilter($builder, $period, $start_date, $end_date);
        
        // Order by latest first
        $builder->orderBy('timestamp', 'DESC');
        
        return $builder->findAll();
    }
    
    // Apply period filter to query builder
    private function applyPeriodFilter(&$builder, $period, $start_date, $end_date)
    {
        $today = date('Y-m-d');
        
        switch ($period) {
            case 'today':
                $builder->where('DATE(timestamp)', $today);
                break;
                
            case 'week':
                $start_week = date('Y-m-d', strtotime('monday this week'));
                $end_week = date('Y-m-d', strtotime('sunday this week'));
                $builder->where('DATE(timestamp) >=', $start_week)
                        ->where('DATE(timestamp) <=', $end_week);
                break;
                
            case 'month':
                $start_month = date('Y-m-01');
                $end_month = date('Y-m-t');
                $builder->where('DATE(timestamp) >=', $start_month)
                        ->where('DATE(timestamp) <=', $end_month);
                break;
                
            case 'custom':
                if ($start_date && $end_date) {
                    $builder->where('DATE(timestamp) >=', $start_date)
                            ->where('DATE(timestamp) <=', $end_date);
                }
                break;
                
            // 'all' - no filter
        }
    }
}