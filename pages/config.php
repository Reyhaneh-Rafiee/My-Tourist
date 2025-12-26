<?php
// config.php در پوشه php/
session_start();

$connect = mysqli_connect('localhost', 'root', '', 'my_tourist_db');

// چک کردن اتصال
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// تنظیم charset
mysqli_set_charset($connect, "utf8mb4");

// توابع کمکی
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function getCurrentUser() {
    return $_SESSION['user_id'] ?? null;
}

function getUserData($user_id = null) {
    global $connect;
    
    if ($user_id === null) {
        $user_id = getCurrentUser();
    }
    
    if (!$user_id) return null;
    
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    
    return null;
}

// تابع برای گرفتن اطلاعات تور
function getTourData($tour_id) {
    global $connect;
    
    $sql = "SELECT * FROM tours WHERE t_id = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "i", $tour_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    
    return null;
}
?>