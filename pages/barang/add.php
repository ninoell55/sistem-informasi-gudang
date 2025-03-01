<?php
session_start();
include '../../config/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Jika kode_jenis tidak ada, arahkan ke pilih jenis alat
if (!isset($_GET['kode_jenis'])) {
    header('Location: ../pilih_jenis_alat.php?redirect=barang/add.php');
    exit();
}

$kode_jenis = $_GET['kode_jenis'];

if (isset($_POST['submit'])) {
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $satuan = $_POST['satuan'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];

    $query = "INSERT INTO barang (kode_barang, nama_barang, satuan, harga_beli, stok, kode_jenis) 
              VALUES ('$kode_barang', '$nama_barang', '$satuan', '$harga_beli', '$stok', '$kode_jenis')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Barang berhasil ditambahkan!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan barang.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - Sistem Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h1 class="text-2xl font-bold text-center mb-4">Tambah Barang</h1>
        <form method="POST">
            <label class="block font-semibold">Kode Jenis: <?= $kode_jenis ?></label>
            <input type="hidden" name="kode_jenis" value="<?= $kode_jenis ?>">

            <input type="text" name="kode_barang" placeholder="Kode Barang" class="block w-full p-2 border rounded mb-2" required>
            <input type="text" name="nama_barang" placeholder="Nama Barang" class="block w-full p-2 border rounded mb-2" required>
            <input type="text" name="satuan" placeholder="Satuan (pcs, kg, dll.)" class="block w-full p-2 border rounded mb-2" required>
            <input type="number" name="harga_beli" placeholder="Harga Beli" class="block w-full p-2 border rounded mb-2" required>
            <input type="number" name="stok" placeholder="Stok Awal" class="block w-full p-2 border rounded mb-2" required>

            <button type="submit" name="submit" class="bg-blue-500 text-white p-2 w-full rounded">Simpan</button>
            <a href="../dashboard.php" class="block text-center mt-2 text-blue-500">Kembali ke Dashboard</a>
        </form>
    </div>
</body>

</html>