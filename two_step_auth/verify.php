<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

require_once 'db_connect.php';

// Cek apakah user sudah melewati login dan punya sesi pending OTP
if (empty($_SESSION['pending_user_id'])) {
  go('index.php?e=Sesi login tidak valid. Silakan login lagi.');
}

$info = ''; // variabel buat menampung pesan error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $inputOtp = trim($_POST['otp'] ?? '');
  $uid = $_SESSION['pending_user_id'];

  // Ambil OTP dari database
  $stmt = $mysqli->prepare("SELECT otp, otp_expiry FROM users WHERE id=? LIMIT 1");
  $stmt->bind_param('i', $uid);
  $stmt->execute();
  $res = $stmt->get_result()->fetch_assoc();

  // Validasi OTP
  if (!$res || !$res['otp']) {
    $info = 'OTP tidak ditemukan. Silakan login ulang.';
  } elseif ($res['otp'] !== $inputOtp) {
    $info = 'Kode OTP salah.';
  } elseif (time() > strtotime($res['otp_expiry'])) {
    $info = 'Kode OTP sudah kadaluarsa.';
  } else {
    // Kalau OTP benar
    $mysqli->query("UPDATE users SET otp=NULL, otp_expiry=NULL WHERE id=$uid");
    unset($_SESSION['pending_user_id']);
    $_SESSION['auth_user_id'] = $uid;
    go('dashboard.php');
  }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Verifikasi OTP</title>
  <style>
    body {font-family: Arial; max-width: 420px; margin: 50px auto; text-align: center;}
    input {width: 100%; padding: 10px; margin: 8px 0;}
    button {padding: 10px 14px; background: #007bff; color: white; border: none; border-radius: 5px;}
    .err {color: red;}
  </style>
</head>
<body>
  <h2>Verifikasi OTP</h2>
  <?php if ($info): ?><p class="err"><?= htmlspecialchars($info) ?></p><?php endif; ?>

  <form method="post">
    <label>Masukkan Kode OTP (6 digit)</label>
    <input type="text" name="otp" maxlength="6" pattern="\d{6}" placeholder="123456" required>
    <button type="submit">Verifikasi</button>
  </form>

  <p><a href="index.php">← Kembali ke Login</a></p>
</body>
</html>