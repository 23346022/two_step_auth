<?php require_once 'db_connect.php'; ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Login - Two Step Auth</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      max-width: 400px;
      margin: 50px auto;
      background-color: #f7f7f7;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    input {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    button {
      background-color: #007bff;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background-color: #0056b3;
    }
    h2 { text-align: center; }
    .error { color: red; text-align: center; }
  </style>
</head>
<body>
  <h2>Login</h2>

  <?php if (!empty($_GET['e'])): ?>
    <p class="error"><?=htmlspecialchars($_GET['e'])?></p>
  <?php endif; ?>

  <form method="post" action="send_otp.php">
    <label>Username</label>
    <input type="text" name="username" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
  </form>
</body>
</html>