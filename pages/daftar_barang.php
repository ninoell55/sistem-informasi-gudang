<?php
include '../config/config.php'; // Pastikan file koneksi tersedia

// Pastikan kode jenis alat dikirimkan
if (!isset($_GET['kode_jenis'])) {
    die("Jenis alat tidak ditemukan.");
}

$kode_jenis = mysqli_real_escape_string($conn, $_GET['kode_jenis']);
$query = "SELECT * FROM barang WHERE kode_jenis = '$kode_jenis'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

// Ambil nama jenis alat
$queryJenis = "SELECT nama_jenis FROM jenis_alat WHERE kode_jenis = '$kode_jenis'";
$resultJenis = mysqli_query($conn, $queryJenis);
$jenis = mysqli_fetch_assoc($resultJenis);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Daftar Barang: <?= htmlspecialchars($jenis['nama_jenis']) ?></h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Kode Barang</th>
                    <th class="border p-2">Nama Barang</th>
                    <th class="border p-2">Satuan</th>
                    <th class="border p-2">Harga Beli</th>
                    <th class="border p-2">Stok</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td class="border p-2"> <?= htmlspecialchars($row['kode_barang']) ?> </td>
                        <td class="border p-2"> <?= htmlspecialchars($row['nama_barang']) ?> </td>
                        <td class="border p-2"> <?= htmlspecialchars($row['satuan']) ?> </td>
                        <td class="border p-2">Rp<?= number_format($row['harga_beli'], 0, ',', '.') ?> </td>
                        <td class="border p-2"> <?= htmlspecialchars($row['stok']) ?> </td>
                        <td class="border p-2">
                            <a href="kelola_pembelian.php?kode_barang=<?= $row['kode_barang'] ?>" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-700">Kelola Pembelian</a>
                            <a href="kelola_penggunaan.php?kode_barang=<?= $row['kode_barang'] ?>" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700">Kelola Penggunaan</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>