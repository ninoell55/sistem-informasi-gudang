<?php
session_start();
include '../../config/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

if (isset($_POST['submit'])) {
    $kode_supplier = $_POST['kode_supplier'];
    $nama_supplier = $_POST['nama_supplier'];
    $kontak = $_POST['kontak'];

    $query = "INSERT INTO supplier (kode_supplier, nama_supplier, kontak) VALUES ('$kode_supplier', '$nama_supplier', '$kontak')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Supplier berhasil ditambahkan!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan supplier.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Supplier - Sistem Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h1 class="text-2xl font-bold text-center mb-4">Tambah Supplier</h1>
        <form method="POST">
            <input type="text" name="kode_supplier" placeholder="Kode Supplier" class="block w-full p-2 border rounded mb-2" required>
            <input type="text" name="nama_supplier" placeholder="Nama Supplier" class="block w-full p-2 border rounded mb-2" required>
            <input type="text" name="kontak" placeholder="Kontak" class="block w-full p-2 border rounded mb-2" required>
            <button type="submit" name="submit" class="bg-blue-500 text-white p-2 w-full rounded">Simpan</button>
            <a href="../dashboard.php" class="block text-center mt-2 text-blue-500">Kembali ke Dashboard</a>
        </form>
    </div>
</body>

</html>