<?= $this->include('layouts/header') ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Data Karcis Terverifikasi</h1>
            <p class="small text-muted mb-0">Data karcis bakul yang sudah disetujui/ditolak</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Disetujui
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count(array_filter($karcis_data, function($item) { 
                                    return $item['status_verifikasi'] == 'approved'; 
                                })) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Ditolak
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count(array_filter($karcis_data, function($item) { 
                                    return $item['status_verifikasi'] == 'rejected'; 
                                })) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-x-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
<!-- Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Karcis Terverifikasi</h6>
    </div>
    <div class="card-body">
        <?php if (empty($karcis_data)): ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h5 class="mt-3 text-muted">Belum ada data terverifikasi</h5>
                <p class="text-muted">Data akan muncul setelah proses verifikasi</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Kode Karcis</th>
                            <th>Nama Bakul</th>
                            <th>Berat (kg)</th>
                            <th>Harga Total</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th> <!-- ✅ KOLOM BARU -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($karcis_data as $karcis): ?>
                        <tr>
                            <td>
                                <span class="badge bg-primary"><?= $karcis['kode_karcis'] ?></span>
                            </td>
                            <td><?= $karcis['nama_bakul'] ?></td>
                            <td class="text-end"><?= number_format($karcis['berat_ikan'], 2) ?></td>
                            <td class="text-end">
                                <strong>Rp <?= number_format($karcis['harga_total'], 0, ',', '.') ?></strong>
                            </td>
                            <td><?= $karcis['tanggal_beli'] ?></td>
                            <td>
                                <?php if ($karcis['status_verifikasi'] == 'approved'): ?>
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-lg me-1"></i>Disetujui
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-lg me-1"></i>Ditolak
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($karcis['status_verifikasi'] == 'rejected'): ?>
                                    <!-- ✅ TOMBOL INPUT ULANG HANYA UNTUK DATA DITOLAK -->
                                    <button class="btn btn-warning btn-sm btn-reinput" 
                                            data-id="<?= $karcis['id_karcis'] ?>"
                                            data-nama="<?= $karcis['nama_bakul'] ?>"
                                            data-berat="<?= $karcis['berat_ikan'] ?>"
                                            data-harga="<?= $karcis['harga_total'] ?>">
                                        <i class="bi bi-arrow-clockwise me-1"></i>Input Ulang
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted small">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- JavaScript untuk Input Ulang -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle tombol input ulang
    document.querySelectorAll('.btn-reinput').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            const berat = this.getAttribute('data-berat');
            const harga = this.getAttribute('data-harga');
            
            if (confirm(`Input ulang data untuk ${nama}?\nData akan dikembalikan ke status pending.`)) {
                reinputKarcis(id);
            }
        });
    });
    
    function reinputKarcis(id, nama, berat, harga) {
    // Redirect ke halaman form input ulang dengan data
    window.location.href = `<?= base_url('admin/input-ulang') ?>?` + 
                          `id=${id}&` +
                          `nama=${encodeURIComponent(nama)}&` +
                          `berat=${berat}&` +
                          `harga=${harga}`;
}

document.querySelectorAll('.btn-reinput').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const nama = this.getAttribute('data-nama');
        const berat = this.getAttribute('data-berat');
        const harga = this.getAttribute('data-harga');
        
        if (confirm(`Input ulang data untuk ${nama}?`)) {
            reinputKarcis(id, nama, berat, harga);
        }
    });
});

});
</script>

<?= $this->include('layouts/footer') ?>