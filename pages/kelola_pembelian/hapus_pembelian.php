<?php
session_start();
include '../../config/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

if (!isset($_GET['kode_transaksi'])) {
    header('Location: index.php');
    exit();
}

$kode_transaksi = $_GET['kode_transaksi'];

// Ambil semua barang yang dibeli dalam transaksi ini
$detail_query = "SELECT kode_barang, qty FROM detail_pembelian WHERE kode_transaksi = '$kode_transaksi'";
$detail_result = mysqli_query($conn, $detail_query);

// Kembalikan stok barang
while ($row = mysqli_fetch_assoc($detail_result)) {
    $kode_barang = $row['kode_barang'];
    $qty = $row['qty'];

    mysqli_query($conn, "UPDATE barang SET stok = stok - $qty WHERE kode_barang = '$kode_barang'");
}

// Hapus detail pembelian
mysqli_query($conn, "DELETE FROM detail_pembelian WHERE kode_transaksi = '$kode_transaksi'");

// Hapus pembelian
mysqli_query($conn, "DELETE FROM pembelian WHERE kode_transaksi = '$kode_transaksi'");

echo "<script>alert('Pembelian berhasil dihapus!'); window.location.href='index.php';</script>";
?>