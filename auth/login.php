<?php
session_start();
include '../config/config.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: ../pages/dashboard.php');
        exit();
    } else {
        echo "<script>alert('Username atau password salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Gudang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h1 class="text-2xl font-bold text-center mb-4">Login</h1>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" class="block w-full p-2 border rounded mb-2" required>
            <input type="password" name="password" placeholder="Password" class="block w-full p-2 border rounded mb-2" required>
            <button type="submit" name="login" class="bg-blue-500 text-white p-2 w-full rounded">Masuk</button>
            <p class="text-center mt-2">Belum punya akun? <a href="registrasi.php" class="text-blue-500">Daftar</a></p>
        </form>
    </div>
</body>

</html>