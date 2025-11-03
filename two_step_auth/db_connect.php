<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

session_start();

$host = '127.0.0.1';
$user = 'root';       // user default XAMPP
$pass = '';           // password default kosong
$db   = 'two_step_auth';

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
  die('Koneksi database gagal: ' . $mysqli->connect_error);
}

function go($url) {
  header("Location: $url");
  exit;
}