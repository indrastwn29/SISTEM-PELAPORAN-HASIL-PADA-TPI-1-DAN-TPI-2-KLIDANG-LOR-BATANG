<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class InputUlang extends BaseController
{
    public function index()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        // Ambil data dari URL parameters
        $data = [
            'title' => 'Input Ulang Karcis',
            'id_karcis' => $this->request->getGet('id'),
            'nama_bakul' => urldecode($this->request->getGet('nama') ?? ''),
            'berat_ikan' => $this->request->getGet('berat') ?? 0,
            'harga_total' => $this->request->getGet('harga') ?? 0
        ];

        return view('admin/input_ulang', $data);
    }

    public function process()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $id_karcis = $this->request->getPost('id_karcis');
        $nama_bakul = $this->request->getPost('nama_bakul');
        $berat_ikan = $this->request->getPost('berat_ikan');
        $jumlah_pembelian = $this->request->getPost('jumlah_pembelian');

        try {
        $builder = $db->table('karcis_bakul');
        $builder->insert($data);
        
        $insertId = $db->insertID();

        // ✅ RETURN JSON UNTUK AJAX
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'success', 
                'message' => 'Data berhasil disimpan'
            ]);
        }

        // Redirect untuk form biasa
        return redirect()->to('/admin/input-sukses-bakul')->with('success_data', [
            'id' => $insertId,
            'nama_bakul' => $data['nama_bakul'],
            'total' => $data['total'],
            'jenis' => 'bakul'
        ]);

    } catch (\Exception $e) {
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'Gagal menyimpan: ' . $e->getMessage()
            ]);
        }
        return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }
}