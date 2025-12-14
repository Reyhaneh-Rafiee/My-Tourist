<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_tourist_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// برای دیباگ - نمایش خطاها
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // دریافت داده‌ها
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $description = isset($_POST['desc']) ? trim($_POST['desc']) : '';
    
    // اعتبارسنجی
    if (empty($title) || empty($description)) {
        die("لطفاً عنوان و توضیحات را پر کنید.");
    }
    
    // پردازش آپلود تصویر
    $image_path = NULL; // NULL اگر عکس آپلود نشده
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "../uploads/jazebe/";
        
        // ایجاد پوشه اگر وجود ندارد
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        // ایجاد نام فایل منحصربه‌فرد
        $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $image_name = uniqid() . '_' . time() . '.' . $file_extension;
        $target_file = $target_dir . $image_name;
        
        // بررسی نوع فایل
        $allowed_types = array("jpg", "jpeg", "png", "gif", "webp");
        $imageFileType = strtolower($file_extension);
        
        if (in_array($imageFileType, $allowed_types)) {
            // آپلود فایل
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = "uploads/jazebe/" . $image_name;
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
            $sql = "INSERT INTO jazebe (`title`, `description`, `image_path`) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $title, $description, $image_path);
        } else {
            $sql = "INSERT INTO jazebe (`title`, `description`) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $title, $description);
        }
        
        if ($stmt->execute()) {
            // هدایت به پنل ادمین
            header("Location: ../panel-admin/index.html?msg=jazebe_added");
            exit();
        } else {
            echo "خطا در ذخیره داده: " . $stmt->error;
        }
        
        $stmt->close();
        
    } catch (Exception $e) {
        echo "خطا در عملیات دیتابیس: " . $e->getMessage();
        echo "<br>SQL: " . $sql;
    }
} else {
    echo "داده‌ای ارسال نشده است.";
}

$conn->close();
?>