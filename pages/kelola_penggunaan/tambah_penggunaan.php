<?php
session_start();
include '../../config/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Ambil daftar barang
$barang_result = mysqli_query($conn, "SELECT * FROM barang");

// Proses tambah penggunaan barang
if (isset($_POST['submit'])) {
    $kode_penggunaan = "PGN-" . time();
    $tgl_penggunaan = $_POST['tgl_penggunaan'];
    $kode_pengguna = $_SESSION['username'];

    mysqli_query($conn, "INSERT INTO penggunaan (kode_penggunaan, tgl_penggunaan, kode_pengguna, total) VALUES 
                        ('$kode_penggunaan', '$tgl_penggunaan', '$kode_pengguna', 0)");

    $total_penggunaan = 0;
    foreach ($_POST['barang'] as $index => $kode_barang) {
        $qty = $_POST['qty'][$index];
        $harga_beli = $_POST['harga_beli'][$index];
        $stok_barang = $_POST['stok'][$index];
        $total = $qty * $harga_beli;
        $total_penggunaan += $total;

        if ($qty > $stok_barang) {
            echo "<script>alert('Gagal! Jumlah penggunaan melebihi stok.'); window.location.href='tambah_penggunaan.php';</script>";
            exit();
        }

        mysqli_query($conn, "INSERT INTO detail_penggunaan (kode_penggunaan, kode_barang, qty, harga_beli, total) 
                            VALUES ('$kode_penggunaan', '$kode_barang', '$qty', '$harga_beli', '$total')");

        mysqli_query($conn, "UPDATE barang SET stok = stok - $qty WHERE kode_barang = '$kode_barang'");
    }

    mysqli_query($conn, "UPDATE penggunaan SET total = '$total_penggunaan' WHERE kode_penggunaan = '$kode_penggunaan'");

    echo "<script>alert('Penggunaan berhasil ditambahkan!'); window.location.href='index.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penggunaan Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function tambahBarang() {
            let container = document.getElementById('barang-container');
            let index = container.children.length;
            let div = document.createElement('div');
            div.classList.add('mb-2', 'flex', 'gap-2');

            div.innerHTML = `
                <select name="barang[]" class="p-2 border rounded w-1/4" onchange="setHargaStok(this, ${index})" required>
                    <option value="">Pilih Barang</option>
                    <?php
                    mysqli_data_seek($barang_result, 0); // Reset hasil query
                    while ($row = mysqli_fetch_assoc($barang_result)) { ?>
                        <option value="<?= $row['kode_barang'] ?>" 
                                data-harga="<?= $row['harga_beli'] ?>" 
                                data-stok="<?= $row['stok'] ?>">
                            <?= $row['nama_barang'] ?>
                        </option>
                    <?php } ?>
                </select>
                <input type="number" name="stok[]" class="p-2 border rounded w-1/6 bg-gray-200" placeholder="Stok" readonly>
                <input type="number" name="qty[]" class="p-2 border rounded w-1/6" placeholder="Qty" required oninput="cekStok(${index})">
                <input type="number" name="harga_beli[]" class="p-2 border rounded w-1/6" placeholder="Harga" readonly>
                <input type="text" class="p-2 border rounded w-1/6" placeholder="Total" id="total-${index}" readonly>
                <button type="button" class="bg-red-500 text-white px-2 rounded" onclick="this.parentElement.remove()">X</button>
            `;
            container.appendChild(div);
        }

        function setHargaStok(select, index) {
            let hargaInput = select.parentElement.children[3];
            let stokInput = select.parentElement.children[1];
            let selectedOption = select.options[select.selectedIndex];

            hargaInput.value = selectedOption.getAttribute('data-harga');
            stokInput.value = selectedOption.getAttribute('data-stok');
            cekStok(index);
        }

        function cekStok(index) {
            let qtyInput = document.getElementsByName('qty[]')[index];
            let stokInput = document.getElementsByName('stok[]')[index];
            let hargaInput = document.getElementsByName('harga_beli[]')[index];
            let totalInput = document.getElementById(`total-${index}`);
            let submitButton = document.getElementById('submit-btn');

            let qty = parseInt(qtyInput.value) || 0;
            let stok = parseInt(stokInput.value) || 0;
            let harga = parseInt(hargaInput.value) || 0;
            let total = qty * harga;

            totalInput.value = total;

            if (qty > stok) {
                qtyInput.classList.add('border-red-500');
                submitButton.disabled = true;
            } else {
                qtyInput.classList.remove('border-red-500');
                submitButton.disabled = false;
            }
        }
    </script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Tambah Penggunaan Barang</h2>
        <form method="POST">
            <label class="block mb-2">Tanggal Penggunaan</label>
            <input type="date" name="tgl_penggunaan" class="block w-full p-2 border rounded mb-4" required>

            <label class="block mb-2">Barang yang Digunakan</label>
            <div id="barang-container" class="mb-4"></div>
            <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded" onclick="tambahBarang()">Tambah Barang</button>

            <button type="submit" name="submit" id="submit-btn" class="bg-green-500 text-white p-2 w-full rounded mt-4">Simpan</button>
            <a href="index.php" class="block text-center mt-2 text-blue-500">Kembali</a>
        </form>
    </div>
</body>

</html>