<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class VerifikasiKarcis extends BaseController
{
    public function index()
{
    // Cek login dan role admin
    if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
        return redirect()->to('/auth/login');
    }

    // Ambil data karcis bakul yang statusnya pending
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
            'Campuran' as jenis_ikan,
            CONCAT('KB-', id_bakul) as kode_karcis,
            status_verifikasi
        FROM karcis_bakul 
        WHERE status_verifikasi = 'pending'  -- ✅ FILTER HANYA YANG PENDING
        ORDER BY tanggal_input DESC
    ");
    
    $karcis_data = $query->getResultArray();
    
    // DEBUG
    $this->writeLog("VerifikasiKarcis - Total pending: " . count($karcis_data));

    $data = [
        'title' => 'Verifikasi Karcis Bakul',
        'karcis_data' => $karcis_data
    ];

    return view('admin/verifikasi_karcis', $data);
}

    public function updateStatus()
{
    // Cek login dan role admin
    if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
    }

    $id_karcis = $this->request->getPost('id_karcis');
    $status = $this->request->getPost('status');

    try {
        $db = db_connect();
        
        // ✅ UPDATE STATUS DI TABEL KARCIS_BAKUL
        $db->query("UPDATE karcis_bakul SET status_verifikasi = ? WHERE id_bakul = ?", 
                   [$status, $id_karcis]);

        // ✅ TAMBAH LOG VERIFIKASI (jika mau)
        $tableExists = $db->tableExists('log_verifikasi');
        if ($tableExists) {
            $db->query("INSERT INTO log_verifikasi (id_karcis, status, verified_by, verified_at) 
                       VALUES (?, ?, ?, NOW())", [$id_karcis, $status, session()->get('user_id')]);
        }

        return $this->response->setJSON([
            'status' => 'success', 
            'message' => 'Karcis berhasil diverifikasi'
        ]);
        
    } catch (\Exception $e) {
        $this->writeLog("Error updateStatus: " . $e->getMessage());
        return $this->response->setJSON([
            'status' => 'error', 
            'message' => 'Gagal memverifikasi: ' . $e->getMessage()
        ]);
    }
}
    private function writeLog($message)
    {
        $logFile = WRITEPATH . 'logs/verifikasi_debug.log';
        $timestamp = date('Y-m-d H:i:s');
        @file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND | LOCK_EX);
    }

    public function success()
{
    // Cek login dan role admin
    if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
        return redirect()->to('/auth/login');
    }

    // Ambil data dari URL parameters
    $id = $this->request->getGet('id');
    $nama = $this->request->getGet('nama');
    $harga = $this->request->getGet('harga');
    $status = $this->request->getGet('status');

    // Validasi data
    if (empty($id)) {
        return redirect()->to('/admin/verifikasi-karcis-bakul');
    }

    // Pastikan semua data ada
    $success_data = [
        'id_karcis' => $id ?? '',
        'nama_bakul' => $nama ? urldecode($nama) : '',
        'harga_total' => $harga ?? 0,
        'status' => $status ?? 'approved'
    ];

    // Debug: Log data untuk troubleshooting
    log_message('debug', 'Success data: ' . print_r($success_data, true));

    return view('admin/verifikasi_success', ['success_data' => $success_data]);
}
}