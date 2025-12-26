<?php

require_once 'config.php';

if (!isLoggedIn() || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: tours.php");
    exit();
}

$order_id = intval($_POST['order_id']);
$user_id = getCurrentUser();

// شبیه‌سازی پرداخت موفق
$payment_success = true; // در واقعیت باید با درگاه بانکی چک شود

if ($payment_success) {
    // استخراج ۴ رقم آخر کارت
    $card_number = isset($_POST['card_number']) ? $_POST['card_number'] : '';
    $last4 = substr(preg_replace('/\D/', '', $card_number), -4);
    
    // به‌روزرسانی وضعیت سفارش
    $sql = "UPDATE orders SET 
            status = 'paid',
            payment_date = NOW(),
            payment_method = ?,
            card_number_last4 = ?
            WHERE o_id = ? AND user_id = ?";
    
    $stmt = mysqli_prepare($connect, $sql);
    
    $payment_method = $_POST['payment_method'] ?? 'card';
    
    mysqli_stmt_bind_param($stmt, "ssii", $payment_method, $last4, $order_id, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        
        // دریافت اطلاعات سفارش برای نمایش
        $sql = "SELECT tracking_code, total_price FROM orders WHERE o_id = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "i", $order_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $order = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        
        // انتقال به صفحه موفقیت
        header("Location: payment-success.php?tracking=" . urlencode($order['tracking_code']) . 
               "&amount=" . $order['total_price']);
        exit();
    } else {
        echo "خطا در به‌روزرسانی: " . mysqli_error($connect);
    }
}

// در صورت خطا
header("Location: payment-failed.php?order_id=" . $order_id);
exit();
?>