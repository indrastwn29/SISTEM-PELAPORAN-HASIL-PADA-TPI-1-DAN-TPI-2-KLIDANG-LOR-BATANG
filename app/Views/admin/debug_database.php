<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Database</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Debug Database</h1>
        
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Table Information</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Table Bakul:</h5>
                        <p><strong><?= $bakul_table ?></strong></p>
                        
                        <?php if (isset($bakul_columns)): ?>
                            <h6>Columns:</h6>
                            <ul>
                                <?php foreach ($bakul_columns as $column): ?>
                                    <li><?= $column ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-6">
                        <h5>Table Kapal:</h5>
                        <p><strong><?= $kapal_table ?></strong></p>
                        
                        <?php if (isset($kapal_columns)): ?>
                            <h6>Columns:</h6>
                            <ul>
                                <?php foreach ($kapal_columns as $column): ?>
                                    <li><?= $column ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if (isset($bakul_sample)): ?>
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Sample Data Bakul (5 records)</h4>
            </div>
            <div class="card-body">
                <pre><?php print_r($bakul_sample) ?></pre>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if (isset($kapal_sample)): ?>
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Sample Data Kapal (5 records)</h4>
            </div>
            <div class="card-body">
                <pre><?php print_r($kapal_sample) ?></pre>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">All Tables in Database</h4>
            </div>
            <div class="card-body">
                <ul>
                    <?php foreach ($tables as $table): ?>
                        <li><?= $table ?></li>
                    <?php endforeach; ?>
                </ul>
                
                <a href="<?= site_url('admin/clearCache') ?>" class="btn btn-warning mt-3">
                    <i class="fas fa-broom"></i> Clear Cache
                </a>
                <a href="<?= site_url('admin') ?>" class="btn btn-primary mt-3">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</body>
</html>