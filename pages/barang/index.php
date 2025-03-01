<?php
session_start();
include '../../config/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

$barang = mysqli_query($conn, "SELECT barang.*, jenis_alat.nama_jenis FROM barang JOIN jenis_alat ON barang.kode_jenis = jenis_alat.kode_jenis");

if (isset($_GET['delete'])) {
    $kode_barang = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM barang WHERE kode_barang='$kode_barang'");
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang - Sistem Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-center mb-4">Daftar Barang</h1>
        <a href="add.php" class="mb-4 inline-block bg-green-500 text-white px-4 py-2 rounded">Tambah Barang</a>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Kode</th>
                    <th class="border p-2">Nama Barang</th>
                    <th class="border p-2">Jenis Alat</th>
                    <th class="border p-2">Satuan</th>
                    <th class="border p-2">Harga Beli</th>
                    <th class="border p-2">Stok</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($barang)) { ?>
                    <tr>
                        <td class="border p-2"> <?= $row['kode_barang'] ?> </td>
                        <td class="border p-2"> <?= $row['nama_barang'] ?> </td>
                        <td class="border p-2"> <?= $row['nama_jenis'] ?> </td>
                        <td class="border p-2"> <?= $row['satuan'] ?> </td>
                        <td class="border p-2"> <?= number_format($row['harga_beli'], 0, ',', '.') ?> </td>
                        <td class="border p-2"> <?= $row['stok'] ?> </td>
                        <td class="border p-2">
                            <a href="edit.php?kode=<?= $row['kode_barang'] ?>" class="text-blue-500">Edit</a>
                            <a href="?delete=<?= $row['kode_barang'] ?>" class="text-red-500 ml-2" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="../dashboard.php" class="block text-center mt-4 text-blue-500">Kembali ke Dashboard</a>
    </div>
</body>

</html>