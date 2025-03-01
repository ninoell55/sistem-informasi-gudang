<?php
session_start();
include '../../config/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

if (isset($_GET['kode'])) {
    $kode_supplier = $_GET['kode'];
    $result = mysqli_query($conn, "SELECT * FROM supplier WHERE kode_supplier='$kode_supplier'");
    $supplier = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $kode_supplier = $_POST['kode_supplier'];
    $nama_supplier = $_POST['nama_supplier'];
    $kontak = $_POST['kontak'];

    mysqli_query($conn, "UPDATE supplier SET nama_supplier='$nama_supplier', kontak='$kontak' WHERE kode_supplier='$kode_supplier'");
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supplier - Sistem Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-center mb-4">Edit Supplier</h1>
        <form method="POST" action="">
            <input type="hidden" name="kode_supplier" value="<?= $supplier['kode_supplier'] ?>">
            <label class="block mb-2">Nama Supplier:</label>
            <input type="text" name="nama_supplier" value="<?= $supplier['nama_supplier'] ?>" class="w-full p-2 border rounded mb-4" required>

            <label class="block mb-2">Kontak:</label>
            <input type="text" name="kontak" value="<?= $supplier['kontak'] ?>" class="w-full p-2 border rounded mb-4" required>

            <button type="submit" name="update" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Perubahan</button>
            <a href="index.php" class="ml-4 text-gray-500">Batal</a>
        </form>
    </div>
</body>

</html>