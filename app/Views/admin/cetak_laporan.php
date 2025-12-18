<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Pelelangan Ikan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; background-color: #e9ecef; }
        .summary { margin-top: 30px; padding: 15px; background-color: #f8f9fa; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PELELANGAN IKAN TPI</h2>
        <p>Kabupaten Batang</p>
        <p>Periode: <?= $periode === 'harian' ? 'Harian' : ($periode === 'bulanan' ? 'Bulanan' : 'Tahunan') ?> - <?= $tanggal ?></p>
        <p>Tanggal Cetak: <?= date('d/m/Y H:i:s') ?></p>
    </div>

    <button class="no-print" onclick="window.print()" style="margin-bottom: 20px;">Cetak Laporan</button>

    <!-- Data Karcis Bakul -->
    <h3>Data Karcis Bakul</h3>
    <table>
        <thead>
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
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3">Total</td>
                <td><?= number_format($total_berat_bakul, 2) ?> kg</td>
                <td colspan="2"></td>
                <td>Rp <?= number_format($total_pembelian, 0, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>

    <!-- Data Karcis Pemilik Kapal -->
    <h3>Data Karcis Pemilik Kapal</h3>
    <table>
        <thead>
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
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3">Total</td>
                <td><?= number_format($total_berat_pemilik, 2) ?> kg</td>
                <td colspan="2"></td>
                <td>Rp <?= number_format($total_penjualan, 0, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>

    <!-- Ring