<?php
session_start();
include '../../config/config.php';

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
    <title>Laporan Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h1 class="text-2xl font-bold text-center mb-4">Pilih Jenis Laporan</h1>
        <ul>
            <li class="mb-2">
                <a href="../pilih_jenis_alat.php?redirect=laporan/laporan_harian.php" class="block bg-blue-500 text-white p-3 rounded text-center">
                    Laporan Harian
                </a>
            </li>
            <li class="mb-2">
                <a href="../pilih_jenis_alat.php?redirect=laporan/laporan_bulanan.php" class="block bg-green-500 text-white p-3 rounded text-center">
                    Laporan Bulanan
                </a>
            </li>
        </ul>
        <a href="../dashboard.php" class="block text-center mt-4 text-blue-500">Kembali ke Dashboard</a>
    </div>
</body>

</html>