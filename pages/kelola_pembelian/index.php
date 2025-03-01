<?php
session_start();
include '../../config/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Ambil daftar pembelian
$pembelian_result = mysqli_query($conn, "SELECT p.kode_transaksi, p.tgl_pembelian, s.nama_supplier, p.total 
    FROM pembelian p 
    JOIN supplier s ON p.kode_supplier = s.kode_supplier 
    ORDER BY p.tgl_pembelian DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pembelian - Sistem Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Daftar Pembelian</h2>
        <a href="tambah_pembelian.php" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">+ Tambah Pembelian</a>
        <table class="w-full border-collapse border border-gray-300 mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Kode Transaksi</th>
                    <th class="border p-2">Tanggal</th>
                    <th class="border p-2">Supplier</th>
                    <th class="border p-2">Total</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($pembelian_result)) { ?>
                    <tr>
                        <td class="border p-2 text-center"><?= $row['kode_transaksi'] ?></td>
                        <td class="border p-2 text-center"><?= $row['tgl_pembelian'] ?></td>
                        <td class="border p-2"><?= htmlspecialchars($row['nama_supplier']) ?></td>
                        <td class="border p-2 text-right">Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                        <td class="border p-2 text-center">
                            <a href="detail_pembelian.php?kode_transaksi=<?= $row['kode_transaksi'] ?>" class="bg-green-500 text-white px-2 py-1 rounded">Detail</a>
                            <a href="hapus_pembelian.php?kode_transaksi=<?= $row['kode_transaksi'] ?>" class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Hapus pembelian ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="../dashboard.php" class="block text-center mt-4 text-blue-500">Kembali ke Dashboard</a>
    </div>
</body>

</html>