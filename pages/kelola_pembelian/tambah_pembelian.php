<?php
session_start();
include '../../config/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Generate kode transaksi otomatis
function generateKodeTransaksi($conn)
{
    $tanggal = date('Ymd');
    $query = "SELECT MAX(kode_transaksi) as max_kode FROM pembelian WHERE kode_transaksi LIKE 'PB-$tanggal-%'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row['max_kode']) {
        $nomor_urut = (int)substr($row['max_kode'], -3) + 1;
    } else {
        $nomor_urut = 1;
    }

    return "PB-$tanggal-" . str_pad($nomor_urut, 3, '0', STR_PAD_LEFT);
}

if (isset($_POST['submit'])) {
    $kode_transaksi = generateKodeTransaksi($conn);
    $tgl_pembelian = $_POST['tgl_pembelian'];
    $kode_supplier = $_POST['kode_supplier'];
    $total = $_POST['total'];

    // Insert ke tabel pembelian
    $query = "INSERT INTO pembelian (kode_transaksi, tgl_pembelian, kode_supplier, total) 
              VALUES ('$kode_transaksi', '$tgl_pembelian', '$kode_supplier', '$total')";
    $insert_pembelian = mysqli_query($conn, $query);

    if ($insert_pembelian) {
        // Insert ke detail_pembelian
        $barang = $_POST['barang'];
        $qty = $_POST['qty'];
        $harga_beli = $_POST['harga_beli'];

        foreach ($barang as $index => $kode_barang) {
            $jumlah = $qty[$index];
            $harga = $harga_beli[$index];
            $total_harga = $jumlah * $harga;

            $query_detail = "INSERT INTO detail_pembelian (kode_transaksi, kode_barang, qty, harga_beli, total) 
                            VALUES ('$kode_transaksi', '$kode_barang', '$jumlah', '$harga', '$total_harga')";
            mysqli_query($conn, $query_detail);

            // Update stok barang
            mysqli_query($conn, "UPDATE barang SET stok = stok + $jumlah WHERE kode_barang = '$kode_barang'");
        }

        echo "<script>alert('Pembelian berhasil ditambahkan!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan pembelian.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pembelian - Sistem Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function tambahBarang() {
            let container = document.getElementById('barang-container');
            let newField = `
                <div class="flex space-x-2 mb-2">
                    <select name="barang[]" class="w-1/3 p-2 border rounded" required>
                        <option value="">Pilih Barang</option>
                        <?php
                        $barang_result = mysqli_query($conn, "SELECT * FROM barang");
                        while ($barang = mysqli_fetch_assoc($barang_result)) {
                            echo "<option value='{$barang['kode_barang']}'>{$barang['nama_barang']}</option>";
                        }
                        ?>
                    </select>
                    <input type="number" name="qty[]" placeholder="Qty" class="w-1/4 p-2 border rounded" required>
                    <input type="number" name="harga_beli[]" placeholder="Harga Beli" class="w-1/4 p-2 border rounded" required>
                    <button type="button" onclick="this.parentElement.remove()" class="bg-red-500 text-white px-2 rounded">Hapus</button>
                </div>`;
            container.insertAdjacentHTML('beforeend', newField);
        }
    </script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h1 class="text-2xl font-bold text-center mb-4">Tambah Pembelian</h1>
        <form method="POST">
            <input type="date" name="tgl_pembelian" class="block w-full p-2 border rounded mb-2" required>
            <select name="kode_supplier" class="block w-full p-2 border rounded mb-2" required>
                <option value="">Pilih Supplier</option>
                <?php
                $suppliers = mysqli_query($conn, "SELECT * FROM supplier");
                while ($supplier = mysqli_fetch_assoc($suppliers)) {
                    echo "<option value='{$supplier['kode_supplier']}'>{$supplier['nama_supplier']}</option>";
                }
                ?>
            </select>

            <div id="barang-container">
                <div class="flex space-x-2 mb-2">
                    <select name="barang[]" class="w-1/3 p-2 border rounded" required>
                        <option value="">Pilih Barang</option>
                        <?php
                        $barang_result = mysqli_query($conn, "SELECT * FROM barang");
                        while ($barang = mysqli_fetch_assoc($barang_result)) {
                            echo "<option value='{$barang['kode_barang']}'>{$barang['nama_barang']}</option>";
                        }
                        ?>
                    </select>
                    <input type="number" name="qty[]" placeholder="Qty" class="w-1/4 p-2 border rounded" required>
                    <input type="number" name="harga_beli[]" placeholder="Harga Beli" class="w-1/4 p-2 border rounded" required>
                </div>
            </div>

            <button type="button" onclick="tambahBarang()" class="bg-green-500 text-white px-3 py-1 rounded mb-2">Tambah Barang</button>
            <input type="number" name="total" placeholder="Total Pembelian" class="block w-full p-2 border rounded mb-2" required>
            <button type="submit" name="submit" class="bg-blue-500 text-white p-2 w-full rounded">Simpan</button>
            <a href="index.php" class="block text-center mt-2 text-blue-500">Kembali</a>
        </form>
    </div>
</body>

</html>