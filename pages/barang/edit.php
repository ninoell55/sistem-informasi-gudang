<?php
session_start();
include '../../config/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

if (isset($_GET['kode'])) {
    $kode_barang = $_GET['kode'];
    $barang_result = mysqli_query($conn, "SELECT * FROM barang WHERE kode_barang='$kode_barang'");
    $barang = mysqli_fetch_assoc($barang_result);

    // Ambil daftar jenis alat
    $jenis_alat = mysqli_query($conn, "SELECT * FROM jenis_alat");
}

if (isset($_POST['update'])) {
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $satuan = $_POST['satuan'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];
    $kode_jenis = $_POST['kode_jenis'];

    mysqli_query($conn, "UPDATE barang SET nama_barang='$nama_barang', satuan='$satuan', harga_beli='$harga_beli', stok='$stok', kode_jenis='$kode_jenis' WHERE kode_barang='$kode_barang'");

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - Sistem Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-center mb-4">Edit Barang</h1>
        <form method="POST">
            <input type="hidden" name="kode_barang" value="<?= $barang['kode_barang'] ?>">

            <label class="block mb-2">Nama Barang:</label>
            <input type="text" name="nama_barang" value="<?= $barang['nama_barang'] ?>" class="w-full p-2 border rounded mb-4" required>

            <label class="block mb-2">Satuan:</label>
            <input type="text" name="satuan" value="<?= $barang['satuan'] ?>" class="w-full p-2 border rounded mb-4" required>

            <label class="block mb-2">Harga Beli:</label>
            <input type="number" name="harga_beli" value="<?= $barang['harga_beli'] ?>" class="w-full p-2 border rounded mb-4" required>

            <label class="block mb-2">Stok:</label>
            <input type="number" name="stok" value="<?= $barang['stok'] ?>" class="w-full p-2 border rounded mb-4" required>

            <label class="block mb-2">Jenis Alat:</label>
            <select name="kode_jenis" class="block w-full p-2 border rounded mb-4" required>
                <option value="">-- Pilih Jenis Alat --</option>
                <?php while ($row = mysqli_fetch_assoc($jenis_alat)) { ?>
                    <option value="<?= $row['kode_jenis'] ?>" <?= ($row['kode_jenis'] == $barang['kode_jenis']) ? 'selected' : '' ?>>
                        <?= $row['nama_jenis'] ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit" name="update" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Perubahan</button>
            <a href="index.php" class="ml-4 text-gray-500">Batal</a>
        </form>
    </div>
</body>

</html>