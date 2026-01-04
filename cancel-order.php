<?php
require_once 'pages/config.php';

if (!isLoggedIn() || !isset($_GET['id'])) {
    header("Location: Customer-orders.php");
    exit;
}

$user_id = getCurrentUser();
$order_id = intval($_GET['id']);

// تغییر وضعیت به cancelled
$sql = "UPDATE orders SET status='cancelled' WHERE o_id=? AND user_id=? AND status='paid'";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "ii", $order_id, $user_id);
$stmt->execute();
$stmt->close();

// بازگشت با پیام موفقیت
header("Location: Customer-orders.php?msg=سفارش با موفقیت لغو شد");
exit;
?>
