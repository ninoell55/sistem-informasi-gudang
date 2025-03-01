<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
            <p>Selamat datang, <strong><?php echo $_SESSION['username']; ?></strong>!</p>
            <div class="mt-4">
                <a href="insert.php" class="bg-blue-500 text-white px-4 py-2 rounded">Insert Data</a>
                <a href="pilih_jenis_alat.php?redirect=cek_persediaan.php" class="bg-yellow-500 text-white px-4 py-2 rounded">Cek Persediaan</a>
                <a href="pilih_jenis_alat.php?redirect=kelola_pembelian/index.php" class="bg-purple-500 text-white px-4 py-2 rounded">Kelola Pembelian</a>
                <a href="pilih_jenis_alat.php?redirect=kelola_penggunaan/index.php" class="bg-red-500 text-white px-4 py-2 rounded">Kelola Penggunaan</a>
                <a href="laporan/index.php" class="bg-indigo-500 text-white px-4 py-2 rounded">Laporan</a>
                <a href="../auth/logout.php" class="bg-gray-500 text-white px-4 py-2 rounded">Logout</a>
            </div>
        </div>
    </div>
</body>

</html>