<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class InputKarcis extends BaseController
{
    public function index()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Input Karcis Bakul - Admin'
        ];

        return view('admin/input_karcis', $data);
    }

public function process()
{
    $request = \Config\Services::request();
    
    if (strtolower($request->getMethod()) === 'post') {
        try {
            $data = [
                'nama_bakul' => $request->getPost('nama_bakul'),
                'alamat' => $request->getPost('alamat'),
                'berat_ikan' => $request->getPost('berat_ikan') ? (float) $request->getPost('berat_ikan') : 0.0,
                'jumlah_karcis' => $request->getPost('jumlah_karcis') ? (int) $request->getPost('jumlah_karcis') : 0,
                'jumlah_pembelian' => $this->clean_number($request->getPost('jumlah_pembelian')),
                'jasa_lelang' => $this->clean_number($request->getPost('jasa_lelang')),
                'lain_lain' => $this->clean_number($request->getPost('lain_lain')),
                'total' => $this->clean_number($request->getPost('total')),
                'jumlah_bayar' => $this->clean_number($request->getPost('jumlah_bayar')),
                'status_verifikasi' => 'pending',
                'tanggal_input' => date('Y-m-d H:i:s')
            ];

            $karcisModel = new \App\Models\KarcisModel();
            $result = $karcisModel->insert($data);
            
            if ($result) {
                // ✅ REDIRECT KE HALAMAN SUKSES
                return redirect()->to('/admin/input-sukses-bakul')->with('success_data', [
                    'id' => $karcisModel->getInsertID(),
                    'nama_bakul' => $data['nama_bakul'],
                    'total' => $data['total']
                ]);
            } else {
                return redirect()->back()->with('error', 'Gagal menyimpan data');
            }
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    return redirect()->back()->with('error', 'Tidak ada data yang dikirim');
}
 
    // METHOD CLEAN_NUMBER
    private function clean_number($val, $default = 0) 
    {
        if (!isset($val) || $val === '') return $default;
        $only = str_replace(['.', ','], '', $val);
        if ($only === '') return $default;
        return (float) $only;
    }

    public function success()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login');
        }

        // Ambil data dari session flashdata
        $success_data = session()->getFlashdata('success_data');
        
        if (!$success_data) {
            // Fallback ke data default
            $success_data = [
                'id' => '123',
                'nama_bakul' => 'Data Test',
                'total' => 0,
                'jenis' => 'bakul'
            ];
        }

        return view('admin/input_success', ['success_data' => $success_data]);
    }
}