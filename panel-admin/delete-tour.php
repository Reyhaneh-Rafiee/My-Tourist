<?php
session_start();

// اتصال به پایگاه داده
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_tourist_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// تنظیم کدگذاری UTF-8
$conn->set_charset("utf8");

// بررسی وجود پارامتر ID
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    // ابتدا بررسی می‌کنیم که آیا رزروی برای این تور وجود دارد؟
    $check_reservations = "SELECT COUNT(*) as total FROM orders WHERE t_id = ?";
    $stmt_check = $conn->prepare($check_reservations);
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row = $result_check->fetch_assoc();

    if ($row['total'] > 0) {
        // اگر رزرو وجود داشت، حذف انجام نشود و پیام بده
        $_SESSION['message'] = "این تور قبلاً رزرو شده و حذف آن امکان‌پذیر نیست.";
        $_SESSION['message_type'] = "warning";
    } else {
        // اگر رزروی نبود، تور را حذف می‌کنیم
        $sql_select = "SELECT title, image_path FROM tours WHERE t_id = ?";
        $stmt_select = $conn->prepare($sql_select);
        $stmt_select->bind_param("i", $id);
        $stmt_select->execute();
        $result = $stmt_select->get_result();
        
        if ($result->num_rows > 0) {
            $tour = $result->fetch_assoc();
            $tour_title = htmlspecialchars($tour['title']);
            $image_path = $tour['image_path'];
            
            // حذف تور از پایگاه داده
            $sql_delete = "DELETE FROM tours WHERE t_id = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("i", $id);
            
            if ($stmt_delete->execute()) {
                // حذف موفقیت‌آمیز
                if (!empty($image_path) && file_exists("../" . $image_path)) {
                    $image_full_path = "../" . $image_path;
                    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif', 'webp');
                    $file_extension = strtolower(pathinfo($image_full_path, PATHINFO_EXTENSION));
                    
                    if (in_array($file_extension, $allowed_extensions)) {
                        if (strpos($image_full_path, '../images/') !== false) {
                            unlink($image_full_path);
                        }
                    }
                }
                
                $_SESSION['message'] = "تور '{$tour_title}' با موفقیت حذف شد.";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "خطا در حذف تور: " . $stmt_delete->error;
                $_SESSION['message_type'] = "danger";
            }
            
            $stmt_delete->close();
        } else {
            $_SESSION['message'] = "تور مورد نظر یافت نشد.";
            $_SESSION['message_type'] = "warning";
        }
        
        $stmt_select->close();
    }

    $stmt_check->close();
} else {
    $_SESSION['message'] = "شناسه تور مشخص نشده است.";
    $_SESSION['message_type'] = "danger";
}

$conn->close();

// هدایت کاربر به صفحه لیست تورها در پنل ادمین
header("Location: index.php");
exit();
?>
