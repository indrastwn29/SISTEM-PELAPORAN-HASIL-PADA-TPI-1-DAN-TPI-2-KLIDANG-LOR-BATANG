<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body py-5">
                        <div class="mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h3 class="card-title text-success">Data Berhasil Disimpan!</h3>
                        <p class="card-text mt-3"><?= $message ?></p>
                        <div class="mt-4">
                            <a href="<?= base_url('karcis-bakul') ?>" class="btn btn-primary me-2">
                                <i class="fas fa-plus"></i> Input Data Baru
                            </a>
                            <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-home"></i> Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>