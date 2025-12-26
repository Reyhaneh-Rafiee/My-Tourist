
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
    
    // ابتدا اطلاعات تور را دریافت می‌کنیم (برای حذف تصویر)
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
            
            // حذف تصویر از سرور (اگر وجود دارد)
            if (!empty($image_path) && file_exists("../" . $image_path)) {
                $image_full_path = "../" . $image_path;
                // فقط فایل‌های تصویری را حذف کن (برای جلوگیری از حذف اشتباه)
                $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif', 'webp');
                $file_extension = strtolower(pathinfo($image_full_path, PATHINFO_EXTENSION));
                
                if (in_array($file_extension, $allowed_extensions)) {
                    // بررسی می‌کنیم که مسیر در پوشه images باشد (برای امنیت)
                    if (strpos($image_full_path, '../images/') !== false) {
                        unlink($image_full_path);
                        $image_deleted = true;
                    }
                }
            }
            
            $_SESSION['message'] = "تور '{$tour_title}' با موفقیت حذف شد.";
            $_SESSION['message_type'] = "success";
        } else {
            // خطا در حذف
            $_SESSION['message'] = "خطا در حذف تور: " . $stmt_delete->error;
            $_SESSION['message_type'] = "danger";
        }
        
        $stmt_delete->close();
    } else {
        // تور یافت نشد
        $_SESSION['message'] = "تور مورد نظر یافت نشد.";
        $_SESSION['message_type'] = "warning";
    }
    
    $stmt_select->close();
} else {
    // ID ارسال نشده
    $_SESSION['message'] = "شناسه تور مشخص نشده است.";
    $_SESSION['message_type'] = "danger";
}

$conn->close();

// هدایت کاربر به صفحه لیست تورها در پنل ادمین
header("Location: index.php");
exit();
?>