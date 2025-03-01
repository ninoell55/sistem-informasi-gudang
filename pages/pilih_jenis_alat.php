<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Ambil semua jenis alat dari database
$jenis_alat = mysqli_query($conn, "SELECT * FROM jenis_alat");

// Ambil halaman tujuan dari parameter URL
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'dashboard.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Jenis Alat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-center mb-4">Pilih Jenis Alat</h1>
        <div class="grid grid-cols-2 gap-4">
            <?php while ($row = mysqli_fetch_assoc($jenis_alat)) { ?>
                <a href="<?= $redirect ?>?kode_jenis=<?= $row['kode_jenis'] ?>"
                    class="block p-4 bg-blue-500 text-white text-center rounded hover:bg-blue-600">
                    <?= $row['nama_jenis'] ?>
                </a>
            <?php } ?>
        </div>
        <a href="dashboard.php" class="block text-center mt-4 text-blue-500">Kembali ke Dashboard</a>
    </div>
</body>

</html>