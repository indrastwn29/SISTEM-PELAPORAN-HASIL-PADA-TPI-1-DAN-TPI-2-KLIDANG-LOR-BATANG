<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class DataTerverifikasi extends BaseController
{
    public function index()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        // Ambil data karcis bakul yang sudah terverifikasi
        $db = db_connect();
        $query = $db->query("
            SELECT 
                id_bakul as id_karcis,
                nama_bakul,
                alamat,
                berat_ikan,
                jumlah_karcis,
                jumlah_pembelian,
                jasa_lelang,
                lain_lain,
                total as harga_total,
                jumlah_bayar,
                tanggal_input as tanggal_beli,
                status_verifikasi,
                'Campuran' as jenis_ikan,
                CONCAT('KB-', id_bakul) as kode_karcis
            FROM karcis_bakul 
            WHERE status_verifikasi IN ('approved', 'rejected')
            ORDER BY tanggal_input DESC
        ");
        
        $data = [
            'title' => 'Data Karcis Terverifikasi',
            'karcis_data' => $query->getResultArray()
        ];

        return view('admin/data_terverifikasi', $data);
    }

    public function reinput()
{
    // Cek login dan role admin
    if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
    }

    $id_karcis = $this->request->getPost('id_karcis');

    try {
        $db = db_connect();
        
        // Update status kembali ke pending
        $db->query("UPDATE karcis_bakul SET status_verifikasi = 'pending' WHERE id_bakul = ?", [$id_karcis]);

        return $this->response->setJSON([
            'status' => 'success', 
            'message' => 'Data berhasil dikembalikan ke status pending'
        ]);
        
    } catch (\Exception $e) {
        return $this->response->setJSON([
            'status' => 'error', 
            'message' => 'Gagal menginput ulang: ' . $e->getMessage()
        ]);
    }
}
}