<?php
// add-tour.php در پوشه php/
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_tourist_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// تنظیم کدگذاری
$conn->set_charset("utf8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // دریافت و اعتبارسنجی داده‌ها
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $description = isset($_POST['desc']) ? trim($_POST['desc']) : '';
    
    // قیمت: حذف "تومان" و فقط عدد بگیر
    $price = isset($_POST['price']) ? trim($_POST['price']) : '';
    $price = preg_replace('/[^0-9]/', '', $price); // فقط اعداد
    
    // دیباگ
    echo "عنوان: " . htmlspecialchars($title) . "<br>";
    echo "توضیحات: " . (strlen($description) > 50 ? substr($description, 0, 50) . "..." : $description) . "<br>";
    echo "قیمت دریافتی: '$price'<br>";
    
    // اعتبارسنجی بهتر
    $errors = [];
    
    if (empty($title)) {
        $errors[] = "عنوان تور الزامی است";
    }
    
    if (empty($description)) {
        $errors[] = "توضیحات تور الزامی است";
    }
    
    if (empty($price)) {
        $errors[] = "قیمت تور الزامی است";
    } elseif ($price == '0' || $price == 0) {
        $errors[] = "قیمت باید بیشتر از صفر باشد";
    } elseif (!is_numeric($price)) {
        $errors[] = "قیمت باید عدد باشد";
    } elseif ($price < 1000) {
        $errors[] = "قیمت معتبر نیست (حداقل 1000 ریال)";
    }
    
    if (!empty($errors)) {
        echo "<div style='color: red; border: 1px solid red; padding: 10px; margin: 10px;'>";
        echo "<h3>خطا:</h3>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo "<a href='javascript:history.back()'>بازگشت و تصحیح</a>";
        echo "</div>";
        exit();
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
                echo "<p style='color: green;'>تصویر با موفقیت آپلود شد.</p>";
            } else {
                echo "<p style='color: orange;'>خطا در آپلود فایل.</p>";
            }
        } else {
            echo "<p style='color: orange;'>فرمت فایل مجاز نیست. فقط JPG, JPEG, PNG, GIF, WebP مجاز هستند.</p>";
        }
    } else {
        echo "<p style='color: orange;'>هیچ تصویری انتخاب نشده یا خطا در آپلود تصویر.</p>";
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
            $tour_id = $stmt->insert_id;
            echo "<div style='color: green; border: 1px solid green; padding: 10px; margin: 10px;'>";
            echo "<h3>تور با موفقیت اضافه شد!</h3>";
            echo "<p>شناسه تور: $tour_id</p>";
            echo "<p>عنوان: " . htmlspecialchars($title) . "</p>";
            echo "<p>قیمت: " . number_format($price) . " تومان</p>";
            if ($image_path) {
                echo "<p>تصویر: <a href='../$image_path' target='_blank'>مشاهده</a></p>";
            }
            echo "</div>";
            
            echo "<script>
                    setTimeout(function() {
                        window.location.href = '../panel-admin/index.html?msg=tour_added&id=' + $tour_id;
                    }, 3000);
                  </script>";
            
            $stmt->close();
        } else {
            echo "<p style='color: red;'>خطا در ذخیره تور در دیتابیس: " . $stmt->error . "</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>خطا: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>داده‌ای ارسال نشده است.</p>";
    echo "<a href='../panel-admin/add-new-tour.html'>بازگشت به فرم</a>";
}

$conn->close();
?>