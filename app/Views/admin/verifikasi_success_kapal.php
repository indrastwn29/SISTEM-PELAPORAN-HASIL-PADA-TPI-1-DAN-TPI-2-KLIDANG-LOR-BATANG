<?= $this->include('layouts/header') ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Verifikasi Berhasil</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-success">
            <h6 class="m-0 font-weight-bold text-white">✅ Karcis Pemilik Kapal Berhasil Diverifikasi</h6>
        </div>
        <div class="card-body text-center">
            <div class="alert alert-success">
                <h4>🎉 Verifikasi Berhasil!</h4>
                <p class="mb-1">Karcis pemilik kapal telah berhasil 
                    <strong><?= $success_data['status'] === 'approved' ? 'disetujui' : 'ditolak' ?></strong>
                </p>
                <p class="mb-1"><strong>ID Karcis:</strong> <?= $success_data['id_karcis'] ?? 'N/A' ?></p>
            </div>
            
            <div class="d-flex justify-content-center gap-2">
                <a href="<?= site_url('admin/verifikasi-karcis-pemilik-kapal') ?>" class="btn btn-primary">
                    <i class="bi bi-list-check me-2"></i>Kembali ke Verifikasi
                </a>
                <a href="<?= base_url('admin') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-house me-2"></i>Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layouts/footer') ?>