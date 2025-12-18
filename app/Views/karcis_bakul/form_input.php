<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .form-label {
            font-weight: 600;
        }
        .required:after {
            content: " *";
            color: red;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-ticket-alt"></i> FORM INPUT KARCIS BAKUL</h4>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('karcis-bakul/simpan') ?>" method="post" id="formKarcis">
                            <?= csrf_field() ?>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nomor_karcis" class="form-label required">Nomor Karcis</label>
                                    <input type="text" class="form-control <?= ($validation->hasError('nomor_karcis')) ? 'is-invalid' : '' ?>" 
                                           id="nomor_karcis" name="nomor_karcis" value="<?= old('nomor_karcis') ?>" 
                                           placeholder="Masukkan nomor karcis" required>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nomor_karcis') ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="nama_bakul" class="form-label required">Nama Bakul</label>
                                    <input type="text" class="form-control <?= ($validation->hasError('nama_bakul')) ? 'is-invalid' : '' ?>" 
                                           id="nama_bakul" name="nama_bakul" value="<?= old('nama_bakul') ?>" 
                                           placeholder="Masukkan nama bakul" required>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama_bakul') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="alamat" class="form-label required">Alamat Lengkap</label>
                                    <textarea class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : '' ?>" 
                                              id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap" required><?= old('alamat') ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('alamat') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="berat_ikan" class="form-label required">Berat Ikan (kg)</label>
                                    <input type="number" step="0.01" class="form-control <?= ($validation->hasError('berat_ikan')) ? 'is-invalid' : '' ?>" 
                                           id="berat_ikan" name="berat_ikan" value="<?= old('berat_ikan') ?>" 
                                           placeholder="0.00" required>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('berat_ikan') ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="jumlah_karcis" class="form-label required">Jumlah Karcis</label>
                                    <input type="number" class="form-control <?= ($validation->hasError('jumlah_karcis')) ? 'is-invalid' : '' ?>" 
                                           id="jumlah_karcis" name="jumlah_karcis" value="<?= old('jumlah_karcis') ?>" 
                                           placeholder="0" required>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('jumlah_karcis') ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="jumlah_pembelian" class="form-label required">Jumlah Pembelian (Rp)</label>
                                    <input type="number" step="0.01" class="form-control <?= ($validation->hasError('jumlah_pembelian')) ? 'is-invalid' : '' ?>" 
                                           id="jumlah_pembelian" name="jumlah_pembelian" value="<?= old('jumlah_pembelian') ?>" 
                                           placeholder="0.00" required>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('jumlah_pembelian') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="jasa_lelang" class="form-label required">Jasa Lelang (Rp)</label>
                                    <input type="number" step="0.01" class="form-control <?= ($validation->hasError('jasa_lelang')) ? 'is-invalid' : '' ?>" 
                                           id="jasa_lelang" name="jasa_lelang" value="<?= old('jasa_lelang') ?>" 
                                           placeholder="0.00" required>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('jasa_lelang') ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="lain_lain" class="form-label">Lain-lain (Rp)</label>
                                    <input type="number" step="0.01" class="form-control <?= ($validation->hasError('lain_lain')) ? 'is-invalid' : '' ?>" 
                                           id="lain_lain" name="lain_lain" value="<?= old('lain_lain') ?? 0 ?>" 
                                           placeholder="0.00">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('lain_lain') ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Total (Rp)</label>
                                    <input type="text" class="form-control bg-light" id="total" readonly 
                                           value="0.00" style="font-weight: bold; color: #d63384;">
                                    <small class="form-text text-muted">*Terhitung otomatis</small>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="reset" class="btn btn-secondary me-md-2">
                                            <i class="fas fa-redo"></i> Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Simpan Data
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
    <script>
        // Fungsi hitung total otomatis
        function hitungTotal() {
            const jumlahPembelian = parseFloat(document.getElementById('jumlah_pembelian').value) || 0;
            const jasaLelang = parseFloat(document.getElementById('jasa_lelang').value) || 0;
            const lainLain = parseFloat(document.getElementById('lain_lain').value) || 0;
            
            const total = jumlahPembelian + jasaLelang + lainLain;
            document.getElementById('total').value = total.toLocaleString('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // Event listeners untuk input yang mempengaruhi total
        document.getElementById('jumlah_pembelian').addEventListener('input', hitungTotal);
        document.getElementById('jasa_lelang').addEventListener('input', hitungTotal);
        document.getElementById('lain_lain').addEventListener('input', hitungTotal);

        // Hitung total saat pertama kali load
        document.addEventListener('DOMContentLoaded', hitungTotal);
    </script>
</body>
</html>