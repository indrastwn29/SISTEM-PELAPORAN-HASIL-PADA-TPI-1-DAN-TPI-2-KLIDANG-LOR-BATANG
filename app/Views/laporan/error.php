<!DOCTYPE html>
<html>
<head>
    <title>Error - Sistem Lelang Ikan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-danger">
            <h4>Terjadi Error</h4>
            <p><?= $message ?></p>
            <a href="<?= base_url('laporan') ?>" class="btn btn-primary">Kembali ke Laporan</a>
        </div>
    </div>
</body>
</html>