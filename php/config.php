<?php
$connect = mysqli_connect('localhost', 'root', '', 'my_tourist_db');

// چک کردن اتصال
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// تنظیم charset
mysqli_set_charset($connect, "utf8mb4");
?>