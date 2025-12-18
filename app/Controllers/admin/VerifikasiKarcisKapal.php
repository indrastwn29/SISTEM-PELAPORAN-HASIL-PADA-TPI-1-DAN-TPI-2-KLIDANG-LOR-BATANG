<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KarcisPemilikKapalModel;

class VerifikasiKarcisKapal extends BaseController
{
    protected $karcisKapalModel;

    public function __construct()
    {
        $this->karcisKapalModel = new KarcisPemilikKapalModel();
    }

    public function index()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        // Ambil data karcis pemilik kapal yang status pending
        $karcis_data = $this->karcisKapalModel->where('status_verifikasi', 'pending')->findAll();

        $data = [
            'title' => 'Verifikasi Karcis Pemilik Kapal',
            'karcis_data' => $karcis_data
        ];

        return view('admin/verifikasi_karcis_kapal', $data);
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
            $data = [
                'status_verifikasi' => $status,
                'verified_by' => session()->get('user_id'),
                'verified_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->karcisKapalModel->update($id_karcis, $data);

            if ($result) {
                return $this->response->setJSON([
                    'status' => 'success', 
                    'message' => 'Status berhasil diupdate'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error', 
                    'message' => 'Gagal update status'
                ]);
            }

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function success()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        // Ambil data dari query string
        $success_data = [
            'id_karcis' => $this->request->getGet('id'),
            'nama_pemilik' => $this->request->getGet('nama'),
            'harga_total' => $this->request->getGet('harga'),
            'status' => $this->request->getGet('status')
        ];

        return view('admin/verifikasi_success_kapal', ['success_data' => $success_data]);
    }
}