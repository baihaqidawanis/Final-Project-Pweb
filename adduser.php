<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "pbw2024";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak bisa terkoneksi ke database");
}

// Username dan password yang akan di-insert
$username = 'admin';
$password = 'admin123'; // Password asli

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Menyimpan data ke database
$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, 'ss', $username, $hashed_password);
if (mysqli_stmt_execute($stmt)) {
    echo "Akun berhasil ditambahkan.";
} else {
    echo "Gagal menambahkan akun.";
}
?>