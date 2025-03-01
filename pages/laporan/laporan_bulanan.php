<?php
session_start();
include '../../config/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

$kode_jenis = isset($_GET['kode_jenis']) ? $_GET['kode_jenis'] : '';
if (empty($kode_jenis)) {
    header('Location: pilih_jenis.php?redirect=laporan_bulanan.php');
    exit();
}

$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');

$query = "SELECT b.kode_barang, b.nama_barang, b.satuan, b.stok 
          FROM barang b 
          WHERE b.kode_jenis = '$kode_jenis'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Laporan Stok Bulanan (<?= $bulan ?>)</h2>

        <form method="GET" class="mb-4">
            <input type="hidden" name="kode_jenis" value="<?= $kode_jenis ?>">
            <label class="block mb-2">Pilih Bulan</label>
            <input type="month" name="bulan" value="<?= $bulan ?>" class="p-2 border rounded">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tampilkan</button>
        </form>

        <table class="w-full border-collapse border border-gray-300 mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Kode Barang</th>
                    <th class="border p-2">Nama Barang</th>
                    <th class="border p-2">Satuan</th>
                    <th class="border p-2">Stok Akhir</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td class="border p-2"><?= $row['kode_barang'] ?></td>
                        <td class="border p-2"><?= htmlspecialchars($row['nama_barang']) ?></td>
                        <td class="border p-2"><?= htmlspecialchars($row['satuan']) ?></td>
                        <td class="border p-2"><?= $row['stok'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- <a href="cetak_bulanan.php?bulan=<?= $bulan ?>&kode_jenis=<?= $kode_jenis ?>"
            class="mt-4 block text-center bg-red-500 text-white p-2 rounded">Cetak PDF</a> -->

        <a href="index.php" class="block text-center mt-4 text-blue-500">Kembali</a>
    </div>
</body>

</html>