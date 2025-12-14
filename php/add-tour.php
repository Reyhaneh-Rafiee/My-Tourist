<?php
// تنظیمات اتصال
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_tourist_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// فعال کردن نمایش خطاها
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // دریافت و اعتبارسنجی داده‌ها
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $description = isset($_POST['desc']) ? trim($_POST['desc']) : '';
    $price = isset($_POST['price']) ? trim($_POST['price']) : '';
    
    if (empty($title) || empty($description) || empty($price)) {
        die("لطفاً تمام فیلدهای ضروری را پر کنید.");
    }
    
    // پردازش آپلود تصویر
    $image_path = null;
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "../uploads/tours/";
        
        // ایجاد پوشه اگر وجود ندارد
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        // ایجاد نام فایل منحصربه‌فرد
        $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $allowed_types = array("jpg", "jpeg", "png", "gif", "webp");
        
        if (in_array($file_extension, $allowed_types)) {
            $image_name = uniqid() . '_' . time() . '.' . $file_extension;
            $target_file = $target_dir . $image_name;
            
            // آپلود فایل
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = "uploads/tours/" . $image_name;
            } else {
                echo "خطا در آپلود فایل.<br>";
            }
        } else {
            echo "فرمت فایل مجاز نیست. فقط JPG, JPEG, PNG, GIF, WebP مجاز هستند.<br>";
        }
    }
    
    try {
        // درج داده در دیتابیس
        if ($image_path) {
            $sql = "INSERT INTO tours (`title`, `description`, `image_path`, `price`) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $title, $description, $image_path, $price);
        } else {
            $sql = "INSERT INTO tours (`title`, `description`, `price`) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $title, $description, $price);
        }
        
        if ($stmt->execute()) {
            // هدایت به پنل ادمین با پیام موفقیت
            header("Location: ../panel-admin/index.html?msg=tour_added");
            exit();
        }
        
        $stmt->close();
        
    } catch (Exception $e) {
        echo "خطا در عملیات دیتابیس: " . $e->getMessage();
    }
} else {
    echo "داده‌ای ارسال نشده است.";
}

$conn->close();
?>