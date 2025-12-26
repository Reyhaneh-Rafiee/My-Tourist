
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
    
    // ابتدا اطلاعات جاذبه را دریافت می‌کنیم (برای حذف تصویر)
    $sql_select = "SELECT title, image_path FROM jazebe WHERE j_id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    
    if ($result->num_rows > 0) {
        $jazebe = $result->fetch_assoc();
        $jazebe_title = htmlspecialchars($jazebe['title']);
        $image_path = $jazebe['image_path'];
        
        // حذف جاذبه از پایگاه داده
        $sql_delete = "DELETE FROM jazebe WHERE j_id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id);
        
        if ($stmt_delete->execute()) {
            // حذف تصویر از سرور (اگر وجود دارد)
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
            
            $_SESSION['message'] = "جاذبه '{$jazebe_title}' با موفقیت حذف شد.";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "خطا در حذف جاذبه: " . $stmt_delete->error;
            $_SESSION['message_type'] = "danger";
        }
        
        $stmt_delete->close();
    } else {
        $_SESSION['message'] = "جاذبه مورد نظر یافت نشد.";
        $_SESSION['message_type'] = "warning";
    }
    
    $stmt_select->close();
} else {
    $_SESSION['message'] = "شناسه جاذبه مشخص نشده است.";
    $_SESSION['message_type'] = "danger";
}

$conn->close();

// هدایت کاربر به صفحه لیست جاذبه‌ها در پنل ادمین
header("Location: jazebeha.php");
exit();
?>