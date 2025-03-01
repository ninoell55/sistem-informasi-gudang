<?php
session_start();
include '../../config/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

if (!isset($_GET['kode_transaksi'])) {
    header('Location: index.php');
    exit();
}

$kode_transaksi = $_GET['kode_transaksi'];

// Ambil data transaksi
$pembelian_query = "SELECT p.kode_transaksi, p.tgl_pembelian, s.nama_supplier, p.total 
                    FROM pembelian p 
                    JOIN supplier s ON p.kode_supplier = s.kode_supplier
                    WHERE p.kode_transaksi = '$kode_transaksi'";
$pembelian_result = mysqli_query($conn, $pembelian_query);
$pembelian = mysqli_fetch_assoc($pembelian_result);

// Ambil detail barang yang dibeli
$detail_query = "SELECT d.kode_barang, b.nama_barang, d.qty, d.harga_beli, d.total 
                 FROM detail_pembelian d 
                 JOIN barang b ON d.kode_barang = b.kode_barang
                 WHERE d.kode_transaksi = '$kode_transaksi'";
$detail_result = mysqli_query($conn, $detail_query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembelian - Sistem Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Detail Pembelian</h2>
        <p><strong>Kode Transaksi:</strong> <?= $pembelian['kode_transaksi'] ?></p>
        <p><strong>Tanggal:</strong> <?= $pembelian['tgl_pembelian'] ?></p>
        <p><strong>Supplier:</strong> <?= htmlspecialchars($pembelian['nama_supplier']) ?></p>
        <p><strong>Total Pembelian:</strong> Rp <?= number_format($pembelian['total'], 0, ',', '.') ?></p>

        <h3 class="text-lg font-bold mt-4">Barang yang Dibeli</h3>
        <table class="w-full border-collapse border border-gray-300 mt-2">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Kode Barang</th>
                    <th class="border p-2">Nama Barang</th>
                    <th class="border p-2">Qty</th>
                    <th class="border p-2">Harga Beli</th>
                    <th class="border p-2">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($detail_result)) { ?>
                    <tr>
                        <td class="border p-2"><?= $row['kode_barang'] ?></td>
                        <td class="border p-2"><?= htmlspecialchars($row['nama_barang']) ?></td>
                        <td class="border p-2"><?= $row['qty'] ?></td>
                        <td class="border p-2">Rp <?= number_format($row['harga_beli'], 0, ',', '.') ?></td>
                        <td class="border p-2">Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="index.php" class="block text-center mt-4 text-blue-500">Kembali</a>
    </div>
</body>

</html>