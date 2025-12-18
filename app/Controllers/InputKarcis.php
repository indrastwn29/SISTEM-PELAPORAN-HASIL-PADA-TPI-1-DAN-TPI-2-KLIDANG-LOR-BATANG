<?php
namespace App\Controllers;

class InputKarcis extends BaseController
{
    public function bakul()
    {
        if ($this->request->getMethod() === 'POST') {
            // Data dari form
            $data = [
                'nama_bakul' => $this->request->getPost('nama_bakul'),
                'alamat' => $this->request->getPost('alamat'),
                'berat_ikan' => (float) $this->request->getPost('berat_ikan'),
                'jumlah_karcis' => (int) $this->request->getPost('jumlah_karcis'),
                'jumlah_pembelian' => (float) str_replace(['.', ','], '', $this->request->getPost('jumlah_pembelian')),
                'jasa_lelang' => (float) str_replace(['.', ','], '', $this->request->getPost('jasa_lelang')),
                'lain_lain' => (float) str_replace(['.', ','], '', $this->request->getPost('lain_lain') ?? 0),
                'total' => (float) str_replace(['.', ','], '', $this->request->getPost('total')),
                'jumlah_bayar' => (float) str_replace(['.', ','], '', $this->request->getPost('jumlah_bayar'))
            ];
            
            // Manual insert
            $db = \Config\Database::connect();
            $result = $db->table('karcis_bakul')->insert($data);
            
            if ($result) {
                $insertId = $db->insertID();
                echo "SUCCESS! Data berhasil disimpan. ID: " . $insertId;
                echo "<br><a href='/lelang-ikan-tpi/petugas/input-karcis-bakul'>Kembali</a>";
                return;
            } else {
                $error = $db->error();
                echo "ERROR: " . $error['message'];
                echo "<br><a href='/lelang-ikan-tpi/petugas/input-karcis-bakul'>Kembali</a>";
                return;
            }
        }
        
        echo "Invalid request";
    }


    public function pemilikKapal()
{
    if ($this->request->getMethod() === 'POST') {
        // Data dari form
        $data = [
            'no_karcis' => $this->request->getPost('nomor_karcis'),
            'nama_pemilik' => $this->request->getPost('nama_nelayan'),
            'nama_kapal' => $this->request->getPost('nama_nelayan') . ' - Kapal',
            'tanggal' => date('Y-m-d'),
            'jenis_ikan' => 'Campuran',
            'berat' => (float) $this->request->getPost('berat_ikan'),
            'harga' => (float) str_replace(['.', ','], '', $this->request->getPost('jumlah_penjualan')),
            'status_verifikasi' => 'pending',
            'petugas_id' => session()->get('user_id')
        ];
        
        // Manual insert ke database
        $db = \Config\Database::connect();
        $result = $db->table('karcis_pemilik_kapal')->insert($data);
        
        if ($result) {
            $insertId = $db->insertID();
            return redirect()->to('/petugas/daftar-karcis-pemilik-kapal')->with('success', 'Karcis pemilik kapal berhasil disimpan! ID: ' . $insertId);
        } else {
            $error = $db->error();
            return redirect()->to('/petugas/input-karcis-pemilik-kapal')->with('error', 'Gagal menyimpan: ' . $error['message']);
        }
    }
    
    return redirect()->to('/petugas/input-karcis-pemilik-kapal');
}
}