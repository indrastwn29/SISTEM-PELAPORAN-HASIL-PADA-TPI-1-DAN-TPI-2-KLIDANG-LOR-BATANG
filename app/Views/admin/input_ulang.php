<?= $this->include('layouts/header') ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Input Ulang Karcis</h1>
            <p class="small text-muted mb-0">Perbaiki data karcis yang ditolak</p>
        </div>
    </div>

    <!-- Form Input Ulang -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Input Ulang</h6>
        </div>
        <div class="card-body">
            <form id="formInputUlang">
                <input type="hidden" name="id_karcis" value="<?= $id_karcis ?>">
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Bakul</label>
                        <input type="text" class="form-control" name="nama_bakul" 
                               value="<?= $nama_bakul ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Berat Ikan (kg)</label>
                        <input type="number" step="0.01" class="form-control" name="berat_ikan" 
                               value="<?= $berat_ikan ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Jumlah Pembelian</label>
                        <input type="number" class="form-control" name="jumlah_pembelian" 
                               value="<?= $harga_total ?>" required>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                    </button>
                    <a href="<?= base_url('admin/data-terverifikasi') ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('formInputUlang').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('<?= site_url('/admin/input-ulang/process') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            window.location.href = '<?= base_url('admin/verifikasi-karcis-bakul') ?>';
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan');
    });
});
</script>

<?= $this->include('layouts/footer') ?>     