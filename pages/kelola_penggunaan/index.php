<?php
session_start();
include '../../config/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Ambil daftar penggunaan barang
$penggunaan = mysqli_query($conn, "SELECT penggunaan.*, users.nama_lengkap FROM penggunaan 
                                   JOIN users ON penggunaan.kode_pengguna = users.username ORDER BY tgl_penggunaan DESC");

// Hapus penggunaan barang
if (isset($_GET['hapus'])) {
    $kode_penggunaan = $_GET['hapus'];

    // Kembalikan stok barang sebelum menghapus
    $detail = mysqli_query($conn, "SELECT kode_barang, qty FROM detail_penggunaan WHERE kode_penggunaan='$kode_penggunaan'");
    while ($row = mysqli_fetch_assoc($detail)) {
        mysqli_query($conn, "UPDATE barang SET stok = stok + {$row['qty']} WHERE kode_barang = '{$row['kode_barang']}'");
    }

    // Hapus detail dan penggunaan barang
    mysqli_query($conn, "DELETE FROM detail_penggunaan WHERE kode_penggunaan='$kode_penggunaan'");
    mysqli_query($conn, "DELETE FROM penggunaan WHERE kode_penggunaan='$kode_penggunaan'");

    echo "<script>alert('Penggunaan berhasil dihapus!'); window.location.href='index.php';</script>";
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penggunaan Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Daftar Penggunaan Barang</h2>
        <a href="tambah_penggunaan.php" class="mb-4 inline-block bg-green-500 text-white px-4 py-2 rounded">Tambah Penggunaan</a>
        <table class="w-full border-collapse border border-gray-300 mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Kode</th>
                    <th class="border p-2">Tanggal</th>
                    <th class="border p-2">Pengguna</th>
                    <th class="border p-2">Total</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($penggunaan)) { ?>
                    <tr>
                        <td class="border p-2"><?= $row['kode_penggunaan'] ?></td>
                        <td class="border p-2"><?= date('d-m-Y', strtotime($row['tgl_penggunaan'])) ?></td>
                        <td class="border p-2"><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                        <td class="border p-2">Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                        <td class="border p-2">
                            <a href="detail_penggunaan.php?kode=<?= $row['kode_penggunaan'] ?>" class="text-blue-500">Detail</a>
                            <a href="?hapus=<?= $row['kode_penggunaan'] ?>" class="text-red-500 ml-2" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="../dashboard.php" class="block text-center mt-4 text-blue-500">Kembali ke Dashboard</a>
    </div>
</body>

</html>