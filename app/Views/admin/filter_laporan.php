<?= $this->include('layouts/header') ?>

<h2>Buat Laporan</h2>

<div class="card">
    <div class="card-body">
        <form method="post" action="<?= site_url('/admin/laporan') ?>">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="periode" class="form-label">Periode Laporan</label>
                        <select class="form-select" id="periode" name="periode" required>
                            <option value="">Pilih Periode</option>
                            <option value="harian">Harian</option>
                            <option value="bulanan">Bulanan</option>
                            <option value="tahunan">Tahunan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">Generate Laporan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Set tanggal default ke hari ini
    document.getElementById('tanggal').valueAsDate = new Date();
</script>

<?= $this->include('layouts/footer') ?>