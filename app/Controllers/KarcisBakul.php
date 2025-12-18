<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KarcisBakulModel;

class KarcisBakul extends BaseController
{
    protected $karcisBakulModel;

    public function __construct()
    {
        $this->karcisBakulModel = new KarcisBakulModel();
        helper(['form', 'number']);
    }

    public function index()
    {
        $data = [
            'title' => 'Input Karcis Bakul',
            'validation' => \Config\Services::validation()
        ];
        return view('karcis_bakul/form_input', $data);
    }

    public function simpan()
    {
        // Validasi input
        if (!$this->validate([
            'nomor_karcis' => [
                'rules' => 'required|is_unique[karcis_bakul.nomor_karcis]',
                'errors' => [
                    'required' => 'Nomor karcis harus diisi',
                    'is_unique' => 'Nomor karcis sudah digunakan'
                ]
            ],
            'nama_bakul' => [
                'rules' => 'required',
                'errors' => ['required' => 'Nama bakul harus diisi']
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => ['required' => 'Alamat harus diisi']
            ],
            'berat_ikan' => [
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'Berat ikan harus diisi',
                    'numeric' => 'Berat ikan harus angka',
                    'greater_than' => 'Berat ikan harus lebih dari 0'
                ]
            ],
            'jumlah_karcis' => [
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'Jumlah karcis harus diisi',
                    'numeric' => 'Jumlah karcis harus angka',
                    'greater_than' => 'Jumlah karcis harus lebih dari 0'
                ]
            ],
            'jumlah_pembelian' => [
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'Jumlah pembelian harus diisi',
                    'numeric' => 'Jumlah pembelian harus angka',
                    'greater_than' => 'Jumlah pembelian harus lebih dari 0'
                ]
            ],
            'jasa_lelang' => [
                'rules' => 'required|numeric|greater_than_equal_to[0]',
                'errors' => [
                    'required' => 'Jasa lelang harus diisi',
                    'numeric' => 'Jasa lelang harus angka',
                    'greater_than_equal_to' => 'Jasa lelang tidak boleh negatif'
                ]
            ],
            'lain_lain' => [
                'rules' => 'numeric|greater_than_equal_to[0]',
                'errors' => [
                    'numeric' => 'Lain-lain harus angka',
                    'greater_than_equal_to' => 'Lain-lain tidak boleh negatif'
                ]
            ]
        ])) {
            return redirect()->back()->withInput();
        }

        // Hitung total otomatis
        $jumlah_pembelian = (float) $this->request->getPost('jumlah_pembelian');
        $jasa_lelang = (float) $this->request->getPost('jasa_lelang');
        $lain_lain = (float) $this->request->getPost('lain_lain') ?? 0;

        $total = $jumlah_pembelian + $jasa_lelang + $lain_lain;

        // Simpan data
        $data = [
            'nomor_karcis' => $this->request->getPost('nomor_karcis'),
            'nama_bakul' => $this->request->getPost('nama_bakul'),
            'alamat' => $this->request->getPost('alamat'),
            'berat_ikan' => $this->request->getPost('berat_ikan'),
            'jumlah_karcis' => $this->request->getPost('jumlah_karcis'),
            'jumlah_pembelian' => $jumlah_pembelian,
            'jasa_lelang' => $jasa_lelang,
            'lain_lain' => $lain_lain,
            'total' => $total,
            'jumlah_bayar' => $total, // Sama dengan total untuk sekarang
            'created_by' => session()->get('user_id') ?? 1, // Ambil dari session
            'status' => 'pending'
        ];

        try {
            $this->karcisBakulModel->save($data);
            session()->setFlashdata('success', 'Data karcis bakul berhasil disimpan!');
            return redirect()->to('/karcis-bakul/sukses');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Gagal menyimpan data: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function sukses()
    {
        $data = [
            'title' => 'Data Berhasil Disimpan',
            'message' => 'Data karcis bakul telah berhasil disimpan dan menunggu verifikasi admin.'
        ];
        return view('karcis_bakul/sukses', $data);
    }
}