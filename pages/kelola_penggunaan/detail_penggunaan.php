<?php
session_start();
include '../../config/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Ambil kode penggunaan dari URL
$kode_penggunaan = isset($_GET['kode']) ? $_GET['kode'] : '';

if (!$kode_penggunaan) {
    header('Location: index.php');
    exit();
}

// Ambil data penggunaan
$penggunaan = mysqli_query($conn, "SELECT penggunaan.*, users.nama_lengkap FROM penggunaan 
                                   JOIN users ON penggunaan.kode_pengguna = users.username 
                                   WHERE kode_penggunaan = '$kode_penggunaan'");
$penggunaan = mysqli_fetch_assoc($penggunaan);

// Ambil detail penggunaan barang
$detail = mysqli_query($conn, "SELECT detail_penggunaan.*, barang.nama_barang, barang.satuan 
                               FROM detail_penggunaan 
                               JOIN barang ON detail_penggunaan.kode_barang = barang.kode_barang 
                               WHERE kode_penggunaan = '$kode_penggunaan'");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penggunaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Detail Penggunaan: <?= htmlspecialchars($penggunaan['kode_penggunaan']) ?></h2>
        <p class="text-center mb-4">Tanggal: <?= date('d-m-Y', strtotime($penggunaan['tgl_penggunaan'])) ?></p>
        <p class="text-center mb-4">Pengguna: <?= htmlspecialchars($penggunaan['nama_lengkap']) ?></p>
        <table class="w-full border-collapse border border-gray-300 mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Nama Barang</th>
                    <th class="border p-2">Satuan</th>
                    <th class="border p-2">Qty</th>
                    <th class="border p-2">Harga</th>
                    <th class="border p-2">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($detail)) { ?>
                    <tr>
                        <td class="border p-2"><?= htmlspecialchars($row['nama_barang']) ?></td>
                        <td class="border p-2"><?= htmlspecialchars($row['satuan']) ?></td>
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