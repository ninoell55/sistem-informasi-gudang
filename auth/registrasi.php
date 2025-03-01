<?php
session_start();
include '../config/config.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $role = 'user';

    $query = "INSERT INTO users (username, password, nama_lengkap, email, role) VALUES ('$username', '$password', '$nama_lengkap', '$email', '$role')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Registrasi gagal!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Sistem Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h1 class="text-2xl font-bold text-center mb-4">Registrasi</h1>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" class="block w-full p-2 border rounded mb-2" required>
            <input type="password" name="password" placeholder="Password" class="block w-full p-2 border rounded mb-2" required>
            <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" class="block w-full p-2 border rounded mb-2" required>
            <input type="email" name="email" placeholder="Email" class="block w-full p-2 border rounded mb-2" required>
            <button type="submit" name="register" class="bg-blue-500 text-white p-2 w-full rounded">Daftar</button>
            <p class="text-center mt-2">Sudah punya akun? <a href="login.php" class="text-blue-500">Login</a></p>
        </form>
    </div>
</body>

</html>