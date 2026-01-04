<?php
ob_start();
session_start();
require_once 'config.php';

if (!isLoggedIn()) {
    header("Location: register-form.html?form=login-user");
    exit();
}

// بررسی ارسال فرم
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: tours.php");
    exit();
}

// دریافت داده‌ها
$tour_id    = intval($_POST['tour_id']);
$user_id    = getCurrentUser();

$name       = trim($_POST['name']);
$phone      = trim($_POST['phone']);
$email      = trim($_POST['email']);
$code       = trim($_POST['code']);
$address    = trim($_POST['address']);
$travelers  = intval($_POST['travelers']);
$notes      = trim($_POST['notes'] ?? '');
$travelDate = !empty($_POST['travel_date_miladi']) ? $_POST['travel_date_miladi'] : null;

// محاسبه مبلغ نهایی
$price_per_person = intval($_POST['tour_price']);
$total_price = $price_per_person * $travelers;

// ذخیره سفارش
$sql = "INSERT INTO orders 
(user_id, t_id, name, phone, email, code, address, travelers, travel_date, notes, total_price, status, created_at)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())";

$stmt = $connect->prepare($sql);

$stmt->bind_param(
    "iisssssisss",
    $user_id,
    $tour_id,
    $name,
    $phone,
    $email,
    $code,
    $address,
    $travelers,
    $travelDate,
    $notes,
    $total_price
);

if (!$stmt->execute()) {
    die("DB ERROR: " . $stmt->error);
}

// ذخیره برای پرداخت
$_SESSION['order_id'] = $stmt->insert_id;
$_SESSION['total_price'] = $total_price;

// انتقال به پرداخت
header("Location: payment.php");
exit();

$stmt->close();
$connect->close();
ob_end_flush();
