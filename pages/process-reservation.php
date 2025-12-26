<?php
// process-reservation.php در پوشه pages/
require_once 'config.php';

// بررسی ورود کاربر
if (!isLoggedIn()) {
    header("Location: login-form.html");
    exit();
}

// بررسی داده‌های POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = getCurrentUser();
    $tour_id = intval($_POST['tour_id']);
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $phone = mysqli_real_escape_string($connect, $_POST['phone']);
    $address = mysqli_real_escape_string($connect, $_POST['address']);
    $code = mysqli_real_escape_string($connect, $_POST['code']);
    $travelers = intval($_POST['travelers']);
    $notes = mysqli_real_escape_string($connect, $_POST['notes'] ?? '');
    $total_price = intval($_POST['tour_price']) * $travelers;
    
    // تولید کد رهگیری منحصر به فرد
    $tracking_code = 'TOUR-' . time() . '-' . rand(1000, 9999);
    
    // ذخیره در دیتابیس
    $sql = "INSERT INTO orders (name, email, phone, address, code, t_id, travelers, notes, total_price, tracking_code, user_id, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
    
    $stmt = mysqli_prepare($connect, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssisisss", $name, $email, $phone, $address, $code, $tour_id, $travelers, $notes, $total_price, $tracking_code, $user_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $order_id = mysqli_insert_id($connect);
            mysqli_stmt_close($stmt);
            
            // انتقال به صفحه پرداخت
            header("Location: payment.php?order_id=" . $order_id);
            exit();
        } else {
            // خطا در اجرا
            echo "خطا در اجرای کوئری: " . mysqli_error($connect);
        }
    } else {
        // خطا در آماده‌سازی
        echo "خطا در آماده‌سازی کوئری: " . mysqli_error($connect);
    }
} else {
    header("Location: tours.php");
    exit();
}
?>