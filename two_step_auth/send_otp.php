<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

require_once 'db_connect.php';

// Ambil data dari form login
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Validasi input
if ($username === '' || $password === '') {
  go('index.php?e=Username/Password wajib diisi');
}

// Cek user di database
$stmt = $mysqli->prepare("SELECT id, password_hash, email FROM users WHERE username=? LIMIT 1");
$stmt->bind_param('s', $username);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();

if (!$user || !password_verify($password, $user['password_hash'])) {
  go('index.php?e=Username atau password salah');
}

// Generate OTP 6 digit dan waktu kadaluarsa (5 menit)
$otp = random_int(100000, 999999);
$expiry = date('Y-m-d H:i:s', time() + 5*60);

// Simpan OTP ke database
$update = $mysqli->prepare("UPDATE users SET otp=?, otp_expiry=? WHERE id=?");
$update->bind_param('ssi', $otp, $expiry, $user['id']);
$update->execute();

// Simpan ID user ke session sementara
$_SESSION['pending_user_id'] = $user['id'];

// Untuk testing: tampilkan OTP di layar
echo "<h2>OTP Kamu: <strong>$otp</strong></h2>";
echo "<p>Kode ini berlaku selama 5 menit.</p>";
echo "<p><a href='verify.php'>Klik di sini untuk menuju halaman verifikasi</a></p>";