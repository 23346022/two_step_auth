<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

require_once 'db_connect.php';

// Hapus semua session dan arahkan ke halaman login
session_unset();
session_destroy();
go('index.php?m=Anda telah logout.');