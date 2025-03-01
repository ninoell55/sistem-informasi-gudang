<?php
session_start();
session_destroy(); // Hapus semua sesi
header('Location: login.php'); // Arahkan ke halaman login
exit();
?>