<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Ambil jenis alat yang dipilih
$kode_jenis = isset($_GET['kode_jenis']) ? $_GET['kode_jenis'] : '';

// Jika belum memilih jenis alat, arahkan ke halaman pilih jenis alat
if (empty($kode_jenis)) {
    header('Location: pilih_jenis_alat.php?redirect=cek_persediaan.php');
    exit();
}

// Ambil data jenis alat
$jenis_result = mysqli_query($conn, "SELECT nama_jenis FROM jenis_alat WHERE kode_jenis = '$kode_jenis'");
$jenis = mysqli_fetch_assoc($jenis_result);

// Ambil daftar barang berdasarkan jenis alat
$barang_result = mysqli_query($conn, "SELECT * FROM barang WHERE kode_jenis = '$kode_jenis'");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Persediaan - Sistem Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Cek Persediaan: <?= htmlspecialchars($jenis['nama_jenis']) ?></h2>

        <a href="pilih_jenis_alat.php?redirect=cek_persediaan.php" class="mb-4 inline-block bg-yellow-500 text-white px-4 py-2 rounded">
            Pilih Jenis Alat Lain
        </a>

        <?php if (mysqli_num_rows($barang_result) > 0) { ?>
            <table class="w-full border-collapse border border-gray-300 mt-4">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">Kode Barang</th>
                        <th class="border p-2">Nama Barang</th>
                        <th class="border p-2">Satuan</th>
                        <th class="border p-2">Harga Beli</th>
                        <th class="border p-2">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($barang_result)) { ?>
                        <tr>
                            <td class="border p-2"><?= $row['kode_barang'] ?></td>
                            <td class="border p-2"><?= htmlspecialchars($row['nama_barang']) ?></td>
                            <td class="border p-2"><?= htmlspecialchars($row['satuan']) ?></td>
                            <td class="border p-2">Rp <?= number_format($row['harga_beli'], 0, ',', '.') ?></td>
                            <td class="border p-2"><?= $row['stok'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p class="text-center text-gray-500 mt-4">Tidak ada barang dalam kategori ini.</p>
        <?php } ?>

        <a href="dashboard.php" class="block text-center mt-4 text-blue-500">Kembali ke Dashboard</a>
    </div>
</body>

</html>