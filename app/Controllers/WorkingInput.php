<?php
namespace App\Controllers;

class WorkingInput extends BaseController
{
    public function bakul()
    {
        // Simple approach - langsung proses tanpa validation
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
            
            // Ambil raw POST (aman untuk debug)
            $raw = $_POST;

            // Proses cleaning angka (hapus titik/koma ribuan)
            $clean_number = function($val, $default = 0) {
                if (!isset($val) || $val === '') return $default;
                $only = str_replace(['.', ','], '', $val);
                if ($only === '') return $default;
                return (float) $only;
            };

            $data = [
                'nama_bakul' => isset($raw['nama_bakul']) ? $raw['nama_bakul'] : '',
                'alamat' => isset($raw['alamat']) ? $raw['alamat'] : '',
                'berat_ikan' => isset($raw['berat_ikan']) && $raw['berat_ikan'] !== '' ? (float) $raw['berat_ikan'] : 0.0,
                'jumlah_karcis' => isset($raw['jumlah_karcis']) && $raw['jumlah_karcis'] !== '' ? (int) $raw['jumlah_karcis'] : 0,
                'jumlah_pembelian' => $clean_number($raw['jumlah_pembelian'] ?? 0),
                'jasa_lelang' => $clean_number($raw['jasa_lelang'] ?? 0),
                'lain_lain' => $clean_number($raw['lain_lain'] ?? 0),
                'total' => $clean_number($raw['total'] ?? 0),
                'jumlah_bayar' => $clean_number($raw['jumlah_bayar'] ?? 0)
            ];

            // Jika total masih 0, hitung manual dari komponennya
            if ($data['total'] == 0) {
                $data['total'] = $data['jumlah_pembelian'] + $data['jasa_lelang'] + $data['lain_lain'];
            }

            // Pakai native MySQL untuk memastikan work
            $host = 'localhost';
            $user = 'root';
            $password = '';
            $database = 'tpi_lelang';

            $conn = mysqli_connect($host, $user, $password, $database);

            if (!$conn) {
                return redirect()->to('/petugas/input-karcis-bakul')->with('error', 'Koneksi database gagal: ' . mysqli_connect_error());
            }

            $sql = "INSERT INTO karcis_bakul (nama_bakul, alamat, berat_ikan, jumlah_karcis, jumlah_pembelian, jasa_lelang, lain_lain, total, jumlah_bayar) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);
            if (!$stmt) {
                mysqli_close($conn);
                return redirect()->to('/petugas/input-karcis-bakul')->with('error', 'Prepare failed: ' . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt, "ssdiddddd",
                $data['nama_bakul'],
                $data['alamat'],
                $data['berat_ikan'],
                $data['jumlah_karcis'],
                $data['jumlah_pembelian'],
                $data['jasa_lelang'],
                $data['lain_lain'],
                $data['total'],
                $data['jumlah_bayar']
            );

            if (mysqli_stmt_execute($stmt)) {
                $insertId = mysqli_insert_id($conn);
                mysqli_stmt_close($stmt);
                mysqli_close($conn);

                // ✅ REDIRECT KE SUCCESS PAGE BAKUL
                return redirect()->to('/petugas/input-sukses-bakul')->with('success_data', [
                    'id' => $insertId,
                    'nama_bakul' => $data['nama_bakul'],
                    'total' => $data['total'],
                    'jenis' => 'bakul'
                ]);

            } else {
                $error = mysqli_stmt_error($stmt);
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                return redirect()->to('/petugas/input-karcis-bakul')->with('error', 'Gagal menyimpan: ' . $error);
            }

        } else {
            return redirect()->to('/petugas/input-karcis-bakul')->with('error', 'Tidak ada data yang dikirim');
        }
    }

    public function pemilikKapal()
    {
        // Simple approach - langsung proses tanpa validation
        if ($_POST) {
            
            // Process data
            $data = [
                'no_karcis' => $_POST['nomor_karcis'],
                'nama_pemilik' => $_POST['nama_nelayan'],
                'nama_kapal' => $_POST['nama_nelayan'] . ' - Kapal',
                'tanggal' => date('Y-m-d'),
                'jenis_ikan' => 'Campuran',
                'berat' => (float) $_POST['berat_ikan'],
                'harga' => (float) str_replace(['.', ','], '', $_POST['jumlah_penjualan']),
                'status_verifikasi' => 'pending',
                'petugas_id' => session()->get('user_id')
            ];
            
            // Pakai native MySQL untuk memastikan work
            $host = 'localhost';
            $user = 'root';
            $password = '';
            $database = 'tpi_lelang';
            
            $conn = mysqli_connect($host, $user, $password, $database);
            
            if (!$conn) {
                return redirect()->to('/petugas/input-karcis-pemilik-kapal')->with('error', 'Koneksi database gagal: ' . mysqli_connect_error());
            }
            
            $sql = "INSERT INTO karcis_pemilik_kapal (no_karcis, nama_pemilik, nama_kapal, tanggal, jenis_ikan, berat, harga, status_verifikasi, petugas_id) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssssddsi", 
                $data['no_karcis'],
                $data['nama_pemilik'],
                $data['nama_kapal'],
                $data['tanggal'],
                $data['jenis_ikan'],
                $data['berat'],
                $data['harga'],
                $data['status_verifikasi'],
                $data['petugas_id']
            );
            
            if (mysqli_stmt_execute($stmt)) {
                $insertId = mysqli_insert_id($conn);
                mysqli_close($conn);
                
                // ✅ REDIRECT KE SUCCESS PAGE KAPAL (SAMA DENGAN BAKUL)
                return redirect()->to('/petugas/input-sukses-kapal')->with('success_data', [
                    'id' => $insertId,
                    'nama_pemilik' => $data['nama_pemilik'],
                    'no_karcis' => $data['no_karcis'],
                    'harga' => $data['harga'],
                    'jenis' => 'kapal'
                ]);
                
            } else {
                $error = mysqli_error($conn);
                mysqli_close($conn);
                return redirect()->to('/petugas/input-karcis-pemilik-kapal')->with('error', 'Gagal menyimpan: ' . $error);
            }
        }
        
        return redirect()->to('/petugas/input-karcis-pemilik-kapal');
    }

    // ✅ METHOD UNTUK SUCCESS PAGE BAKUL
    public function inputSuksesBakul()
    {
        // Ambil data dari session
        $success_data = session()->getFlashdata('success_data');
        
        if (!$success_data) {
            return redirect()->to('/petugas/daftar-karcis-bakul');
        }

        // Tampilkan success page yang sama
        return view('success_page', ['success_data' => $success_data]);
    }

    // ✅ METHOD UNTUK SUCCESS PAGE KAPAL
    public function inputSuksesKapal()
    {
        $success_data = session()->getFlashdata('success_data');
        
        if (!$success_data) {
            return redirect()->to('/petugas/daftar-karcis-pemilik-kapal');
        }

        // Tampilkan success page yang sama
        return view('success_page', ['success_data' => $success_data]);
    }
}