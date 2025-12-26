<?php
// delete-order.php در پوشه panel-admin/
// اتصال به دیتابیس
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_tourist_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // حذف سفارش
    $sql = "DELETE FROM orders WHERE o_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // هدایت به صفحه سفارشات با پیام موفقیت
        header("Location: orders.html?msg=سفارش با موفقیت حذف شد");
    } else {
        header("Location: orders.html?msg=خطا در حذف سفارش");
    }
    
    $stmt->close();
} else {
    header("Location: orders.php");
}

$conn->close();
exit();
?>