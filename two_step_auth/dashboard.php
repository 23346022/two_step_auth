<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

require_once 'db_connect.php';

// Pastikan user sudah login dengan OTP
if (empty($_SESSION['auth_user_id'])) {
  go('index.php?e=Silakan login dulu.');
}

// Ambil data user dari database (biar tampil nama/email)
$stmt = $mysqli->prepare("SELECT username, email FROM users WHERE id=?");
$stmt->bind_param('i', $_SESSION['auth_user_id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Dashboard</title>
  <style>
    body {font-family: Arial; text-align: center; margin-top: 60px;}
    a {color: #007bff; text-decoration: none;}
    a:hover {text-decoration: underline;}
  </style>
</head>
<body>
  <h2>Selamat datang, <?= htmlspecialchars($user['username']) ?> 🎉</h2>
  <p>Email terdaftar: <?= htmlspecialchars($user['email']) ?></p>
  <p>Login dua langkah berhasil ✅</p>
  <br>
  <a href="logout.php">Logout</a>
</body>
</html>
