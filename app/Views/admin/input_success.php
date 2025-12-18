<?= $this->include('layouts/header') ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow mb-4" style="border-radius: 15px;">
                <div class="card-header py-3 text-center" style="background: linear-gradient(135deg, #28a745, #20c997); border-radius: 15px 15px 0 0;">
                    <h4 class="m-0 font-weight-bold text-white">
                        <i class="bi bi-check-circle me-2"></i>Input Berhasil
                    </h4>
                </div>
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h5 class="text-success mb-3">Karcis Berhasil Disimpan!</h5>
                    
                    <div class="alert alert-info text-start">
                        <strong>Detail Karcis:</strong><br>
                        ID: <strong>#<?= $success_data['id'] ?></strong><br>
                        Nama Bakul: <strong><?= $success_data['nama_bakul'] ?></strong><br>
                        Total: <strong>Rp <?= number_format($success_data['total'], 0, ',', '.') ?></strong>
                    </div>
                    
                    <p class="text-muted mb-4">
                        Data telah tersimpan di sistem dan menunggu verifikasi.
                    </p>
                    
                    <div class="d-flex justify-content-center gap-3">
                        <a href="<?= base_url('admin/input-karcis-bakul') ?>" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Input Lagi
                        </a>
                        <a href="<?= base_url('admin/verifikasi-karcis-bakul') ?>" class="btn btn-outline-success">
                            <i class="bi bi-list-check me-2"></i>Lihat Verifikasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layouts/footer') ?>