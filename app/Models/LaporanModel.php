<?php
namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'lelang_ikan';
    protected $primaryKey = 'id_lelang';
    protected $allowedFields = [
        'jenis_ikan', 'tanggal_lelang', 'lokasi_pelelangan', 
        'berat_total', 'harga_awal_per_kg', 'harga_akhir_per_kg',
        'total_nilai_lelang', 'pemenang_lelang', 'status_lelang'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    public function getLaporanIkan($startDate = null, $endDate = null, $jenisIkan = null)
    {
        $builder = $this->db->table('lelang_ikan l');
        $builder->select('l.*, COUNT(pl.id_peserta) as jumlah_peserta');
        $builder->join('peserta_lelang_ikan pl', 'l.id_lelang = pl.id_lelang', 'left');
        
        // Filter tanggal
        if ($startDate && $endDate) {
            $builder->where('l.tanggal_lelang >=', $startDate);
            $builder->where('l.tanggal_lelang <=', $endDate);
        }
        
        // Filter jenis ikan
        if ($jenisIkan) {
            $builder->where('l.jenis_ikan', $jenisIkan);
        }
        
        $builder->groupBy('l.id_lelang');
        $builder->orderBy('l.tanggal_lelang', 'DESC');
        
        return $builder->get()->getResultArray();
    }
    
    public function getDetailLaporanIkan($id_lelang)
    {
        $builder = $this->db->table('lelang_ikan l');
        $builder->select('l.*, pl.nama_perusahaan, pl.harga_penawaran_per_kg, pl.jumlah_penawaran_kg');
        $builder->join('peserta_lelang_ikan pl', 'l.id_lelang = pl.id_lelang', 'left');
        $builder->where('l.id_lelang', $id_lelang);
        $builder->orderBy('pl.harga_penawaran_per_kg', 'DESC');
        
        return $builder->get()->getResultArray();
    }
    
    /**
     * Statistik per jenis ikan
     */
    /**
 * Statistik per jenis ikan DENGAN FILTER
 */
public function getStatistikPerJenis($tahun = null, $jenisIkan = null)
{
    $builder = $this->db->table('lelang_ikan');
    $builder->select('jenis_ikan, 
                     COUNT(*) as total_lelang, 
                     SUM(berat_total) as total_berat,
                     SUM(total_nilai_lelang) as total_nilai,
                     AVG(harga_akhir_per_kg) as avg_harga');
    $builder->where('status_lelang', 'selesai');
    
    // ✅ TAMBAH FILTER TAHUN
    if ($tahun && $tahun != 'all') {
        $builder->where('YEAR(tanggal_lelang)', $tahun);
    }
    
    // ✅ TAMBAH FILTER JENIS IKAN
    if ($jenisIkan && $jenisIkan != 'all') {
        $builder->where('jenis_ikan', $jenisIkan);
    }
    
    $builder->groupBy('jenis_ikan');
    $builder->orderBy('total_nilai', 'DESC');
    
    return $builder->get()->getResultArray();
}
    
    /**
     * Rekap bulanan lelang ikan
     */
    /**
 * Rekap bulanan lelang ikan DENGAN FILTER
 */
public function getRekapBulanan($tahun = null, $jenisIkan = null)
{
    $builder = $this->db->table('lelang_ikan');
    $builder->select("DATE_FORMAT(tanggal_lelang, '%Y-%m') as bulan, 
                     COUNT(*) as total_lelang, 
                     SUM(berat_total) as total_berat,
                     SUM(total_nilai_lelang) as total_nilai");
    $builder->where('status_lelang', 'selesai');
    
    // ✅ TAMBAH FILTER TAHUN
    if ($tahun && $tahun != 'all') {
        $builder->where('YEAR(tanggal_lelang)', $tahun);
    }
    
    // ✅ TAMBAH FILTER JENIS IKAN  
    if ($jenisIkan && $jenisIkan != 'all') {
        $builder->where('jenis_ikan', $jenisIkan);
    }
    
    $builder->groupBy('bulan');
    $builder->orderBy('bulan', 'DESC');
    $builder->limit(12); // 12 bulan terakhir
    
    return $builder->get()->getResultArray();
}
    
    /**
     * Hitung total nilai lelang otomatis
     */
    public function calculateTotalNilai($berat_total, $harga_per_kg)
    {
        return $berat_total * $harga_per_kg;
    }
    
    /**
     * Get trending harga per jenis ikan
     */
    public function getTrendingHarga()
    {
        $builder = $this->db->table('lelang_ikan');
        $builder->select('jenis_ikan, 
                         DATE_FORMAT(tanggal_lelang, "%Y-%m") as bulan,
                         AVG(harga_akhir_per_kg) as avg_harga_bulanan');
        $builder->where('status_lelang', 'selesai');
        $builder->where('tanggal_lelang >=', date('Y-m-01', strtotime('-6 months')));
        $builder->groupBy('jenis_ikan, bulan');
        $builder->orderBy('jenis_ikan');
        $builder->orderBy('bulan');
        
        return $builder->get()->getResultArray();
    }
    
    /**
     * Top 5 pemenang lelang
     */
    public function getTopPemenang()
    {
        $builder = $this->db->table('lelang_ikan');
        $builder->select('pemenang_lelang, 
                         COUNT(*) as total_kemenangan,
                         SUM(total_nilai_lelang) as total_nilai');
        $builder->where('status_lelang', 'selesai');
        $builder->where('pemenang_lelang IS NOT NULL');
        $builder->groupBy('pemenang_lelang');
        $builder->orderBy('total_nilai', 'DESC');
        $builder->limit(5);
        
        return $builder->get()->getResultArray();
    }
}