
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

// متغیرهای فرم
$tour_id = '';
$title = '';
$description = '';
$price_toman = ''; // قیمت به تومان
$image_path = '';
$current_image = '';
$error = '';

// بررسی اگر فرم ارسال شده (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tour_id = intval($_POST['tour_id']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price_toman = floatval($_POST['price']);
    $current_image = $_POST['current_image'];
    
    // تبدیل تومان به ریال برای ذخیره در دیتابیس
    $price_rial = $price_toman * 10;
    
    // پردازش آپلود تصویر
    $new_image_path = $current_image;
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed_extensions)) {
            $new_file_name = 'tour_' . time() . '_' . uniqid() . '.' . $file_ext;
            $upload_path = '../images/tours/' . $new_file_name;
            
            if (!is_dir('../images/tours')) {
                mkdir('../images/tours', 0777, true);
            }
            
            if (move_uploaded_file($file_tmp, $upload_path)) {
                if (!empty($current_image) && file_exists("../" . $current_image) && $current_image != 'images/default-tour.jpg') {
                    unlink("../" . $current_image);
                }
                $new_image_path = 'images/tours/' . $new_file_name;
            }
        }
    }
    
    // آپدیت در دیتابیس
    $sql = "UPDATE tours SET 
            title = ?,
            description = ?,
            price = ?,
            image_path = ?,
            updated_at = NOW()
            WHERE t_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $title, $description, $price_rial, $new_image_path, $tour_id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = 'تور با موفقیت ویرایش شد.';
        $_SESSION['message_type'] = 'success';
        $stmt->close();
        $conn->close();
        header("Location: index.php");
        exit();
    } else {
        $error = 'خطا در ویرایش تور.';
    }
    
    $stmt->close();
} 
// حالت GET (نمایش فرم)
elseif (isset($_GET['id'])) {
    $tour_id = intval($_GET['id']);
    
    // دریافت اطلاعات تور
    $sql = "SELECT * FROM tours WHERE t_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $tour_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $tour = $result->fetch_assoc();
        $title = htmlspecialchars($tour['title']);
        $description = htmlspecialchars($tour['description']);
        $price_toman = $tour['price'] / 10; // تبدیل به تومان
        $current_image = $tour['image_path'];
    } else {
        $error = 'تور مورد نظر یافت نشد.';
    }
    
    $stmt->close();
} else {
    $error = 'شناسه تور مشخص نشده است.';
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ویرایش تور</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
</head>

<body>
  

<nav class="nav top-bar">
    <h2 class="float-left">Admin Panel</h2>
</nav>

<div class="container-fluid">
    <div class="row admin-panel">
        <div class="col-2">
            <div class="list-item">
                <a href="index.php">پیشخوان</a>
                <a href="../index.html">مشاهده سایت</a>
                <a href="add-new-tour.html">تور جدید</a>
                <a href="orders.php">سفارشات تور</a>
                <a href="add-new-jazebe.html">جاذبه جدید</a>
                <a href="jazebeha.php">جاذبه ها</a>
                <a href="../php/logout.php">خروج</a>
            </div>
        </div>
        <div class="col-10">

          <?php if (!empty($error)): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <?php echo $error; ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php endif; ?>

          <form action="edit-tour.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="tour_id" value="<?php echo $tour_id; ?>">
                <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($current_image); ?>">
                
                <!-- table list -->
                <div class="card mb-3">
                    <div class="card-header">
                    ویرایش تور
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table float-right" style="direction: rtl">
                                <thead>
                                <tr>
                                    <th>عنوان</th>
                                    <th>توضیحات</th>
                                    <th>قیمت (تومان)</th>
                                    <th>تصویر</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <input type="text" 
                                               name="title" 
                                               class="form-control" 
                                               value="<?php echo htmlspecialchars($title); ?>" 
                                               required>
                                    </td>
                                    <td>
                                        <textarea name="description" 
                                                  class="form-control" 
                                                  rows="3" 
                                                  required><?php echo htmlspecialchars($description); ?></textarea>
                                    </td>
                                    <td>
                                        <input type="number" 
                                               name="price" 
                                               class="form-control" 
                                               value="<?php echo $price_toman; ?>" 
                                               min="0" 
                                               required>
                                    </td>
                                    <td>
                                        <?php if (!empty($current_image) && file_exists("../" . $current_image)): ?>
                                        <div class="mb-2">
                                            <img src="../<?php echo htmlspecialchars($current_image); ?>" 
                                                 width="100px" 
                                                 height="70px" 
                                                 onerror="this.src='admin-images/default.jpg'">
                                        </div>
                                        <?php endif; ?>
                                        <input type="file" name="image" class="form-control">
                                        <small>برای تغییر تصویر انتخاب کنید</small>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                            <a href="index.php" class="btn btn-secondary">انصراف</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
