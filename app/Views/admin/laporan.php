<?= $this->include('layouts/header') ?>

<h2>Laporan Pelelangan Ikan</h2>

<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <h5>Periode: 
                    <?= $periode === 'harian' ? 'Harian' : ($periode === 'bulanan' ? 'Bulanan' : 'Tahunan') ?>
                    - <?= $tanggal ?>
                </h5>
            </div>
            <div class="col-md-6 text-end">
                <a href="<?= site_url('/admin/cetak-laporan/' . $periode . '/' . $tanggal) ?>" class="btn btn-success" target="_blank">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </a>
                <a href="<?= site_url('/admin/laporan') ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

        <!-- Laporan Karcis Bakul -->
        <h4>Data Karcis Bakul</h4>
        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nomor Karcis</th>
                        <th>Nama Bakul</th>
                        <th>Berat Ikan (kg)</th>
                        <th>Jumlah Pembelian</th>
                        <th>Jasa Lelang</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; $total_berat_bakul = 0; $total_pembelian = 0; ?>
                    <?php foreach ($karcis_bakul as $kb): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $kb['nomor_karcis'] ?></td>
                        <td><?= $kb['nama_bakul'] ?></td>
                        <td><?= $kb['berat_ikan'] ?></td>
                        <td>Rp <?= number_format($kb['jumlah_pembelian'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($kb['jasa_lelang'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($kb['total'], 0, ',', '.') ?></td>
                    </tr>
                    <?php 
                        $total_berat_bakul += $kb['berat_ikan'];
                        $total_pembelian += $kb['total'];
                    ?>
                    <?php endforeach; ?>
                    <?php if (empty($karcis_bakul)): ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data karcis bakul</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot class="table-secondary">
                    <tr>
                        <th colspan="3">Total</th>
                        <th><?= number_format($total_berat_bakul, 2) ?> kg</th>
                        <th colspan="2"></th>
                        <th>Rp <?= number_format($total_pembelian, 0, ',', '.') ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Laporan Karcis Pemilik Kapal -->
        <h4>Data Karcis Pemilik Kapal</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-success">
                    <tr>
                        <th>No</th>
                        <th>Nomor Karcis</th>
                        <th>Nama Nelayan/Kapal</th>
                        <th>Berat Ikan (kg)</th>
                        <th>Jumlah Penjualan</th>
                        <th>Jasa Lelang</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; $total_berat_pemilik = 0; $total_penjualan = 0; ?>
                    <?php foreach ($karcis_pemilik as $kp): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $kp['nomor_karcis'] ?></td>
                        <td><?= $kp['nama_nelayan'] ?></td>
                        <td><?= $kp['berat_ikan'] ?></td>
                        <td>Rp <?= number_format($kp['jumlah_penjualan'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($kp['jasa_lelang'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($kp['total'], 0, ',', '.') ?></td>
                    </tr>
                    <?php 
                        $total_berat_pemilik += $kp['berat_ikan'];
                        $total_penjualan += $kp['total'];
                    ?>
                    <?php endforeach; ?>
                    <?php if (empty($karcis_pemilik)): ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data karcis pemilik kapal</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot class="table-secondary">
                    <tr>
                        <th colspan="3">Total</th>
                        <th><?= number_format($total_berat_pemilik, 2) ?> kg</th>
                        <th colspan="2"></th>
                        <th>Rp <?= number_format($total_penjualan, 0, ',', '.') ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Ringkasan -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Ringkasan Total</h5>
                    </div>
                    <div class="card-body">
                        <p>Total Berat Ikan: <strong><?= number_format($total_berat_bakul + $total_berat_pemilik, 2) ?> kg</strong></p>
                        <p>Total Nilai Transaksi: <strong>Rp <?= number_format($total_pembelian + $total_penjualan, 0, ',', '.') ?></strong></p>
                        <p>Total Jasa Lelang: <strong>Rp <?= number_format(
                            array_sum(array_column($karcis_bakul, 'jasa_lelang')) + 
                            array_sum(array_column($karcis_pemilik, 'jasa_lelang')), 0, ',', '.') 
                        ?></strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layouts/footer') ?>