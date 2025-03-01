<?php
session_start();
include '../../config/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

$suppliers = mysqli_query($conn, "SELECT * FROM supplier");

if (isset($_GET['delete'])) {
    $kode_supplier = $_GET['delete'];
    $stmt = mysqli_prepare($conn, "DELETE FROM supplier WHERE kode_supplier = ?");
    mysqli_stmt_bind_param($stmt, 's', $kode_supplier);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Supplier berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus supplier.";
    }
    mysqli_stmt_close($stmt);
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Supplier - Sistem Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-center mb-4">Daftar Supplier</h1>

        <?php if (isset($_SESSION['success'])) { ?>
            <p class="text-green-600 text-center"> <?= $_SESSION['success'];
                                                    unset($_SESSION['success']); ?> </p>
        <?php } ?>
        <?php if (isset($_SESSION['error'])) { ?>
            <p class="text-red-600 text-center"> <?= $_SESSION['error'];
                                                    unset($_SESSION['error']); ?> </p>
        <?php } ?>

        <a href="add.php" class="mb-4 inline-block bg-green-500 text-white px-4 py-2 rounded">Tambah Supplier</a>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Kode</th>
                    <th class="border p-2">Nama Supplier</th>
                    <th class="border p-2">Kontak</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($suppliers)) { ?>
                    <tr>
                        <td class="border p-2"> <?= htmlspecialchars($row['kode_supplier']) ?> </td>
                        <td class="border p-2"> <?= htmlspecialchars($row['nama_supplier']) ?> </td>
                        <td class="border p-2"> <?= htmlspecialchars($row['kontak']) ?> </td>
                        <td class="border p-2">
                            <a href="edit.php?kode=<?= urlencode($row['kode_supplier']) ?>" class="text-blue-500">Edit</a>
                            <a href="?delete=<?= urlencode($row['kode_supplier']) ?>" class="text-red-500 ml-2" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="../dashboard.php" class="block text-center mt-4 text-blue-500">Kembali ke Dashboard</a>
    </div>
</body>

</html>