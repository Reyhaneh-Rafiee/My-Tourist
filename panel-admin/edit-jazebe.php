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
$jazebe_id = '';
$title = '';
$description = '';
$image_path = '';
$current_image = '';
$error = '';

// بررسی اگر فرم ارسال شده (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jazebe_id = intval($_POST['jazebe_id']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $current_image = $_POST['current_image'];
    
    // پردازش آپلود تصویر
    $new_image_path = $current_image;
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed_extensions)) {
            $new_file_name = 'jazebe_' . time() . '_' . uniqid() . '.' . $file_ext;
            $upload_path = '../images/jazebe/' . $new_file_name;
            
            if (!is_dir('../images/jazebe')) {
                mkdir('../images/jazebe', 0777, true);
            }
            
            if (move_uploaded_file($file_tmp, $upload_path)) {
                if (!empty($current_image) && file_exists("../" . $current_image) && $current_image != 'images/default-jazebe.jpg') {
                    unlink("../" . $current_image);
                }
                $new_image_path = 'images/jazebe/' . $new_file_name;
            }
        }
    }
    
    // آپدیت در دیتابیس
    $sql = "UPDATE jazebe SET 
            title = ?,
            description = ?,
            image_path = ?,
            updated_at = NOW()
            WHERE j_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $description, $new_image_path, $jazebe_id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = 'جاذبه با موفقیت ویرایش شد.';
        $_SESSION['message_type'] = 'success';
        $stmt->close();
        $conn->close();
        header("Location: jazebeha.php");
        exit();
    } else {
        $error = 'خطا در ویرایش جاذبه.';
    }
    
    $stmt->close();
} 
// حالت GET (نمایش فرم)
elseif (isset($_GET['id'])) {
    $jazebe_id = intval($_GET['id']);
    
    // دریافت اطلاعات جاذبه
    $sql = "SELECT * FROM jazebe WHERE j_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $jazebe_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $jazebe = $result->fetch_assoc();
        $title = htmlspecialchars($jazebe['title']);
        $description = htmlspecialchars($jazebe['description']);
        $current_image = $jazebe['image_path'];
    } else {
        $error = 'جاذبه مورد نظر یافت نشد.';
    }
    
    $stmt->close();
} else {
    $error = 'شناسه جاذبه مشخص نشده است.';
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ویرایش جاذبه</title>
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

          <form action="edit-jazebe.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="jazebe_id" value="<?php echo $jazebe_id; ?>">
                <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($current_image); ?>">
                
                <!-- table list -->
                <div class="card mb-3">
                    <div class="card-header">
                    ویرایش جاذبه
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table float-right" style="direction: rtl">
                                <thead>
                                <tr>
                                    <th>عنوان</th>
                                    <th>توضیحات</th>
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
                            <a href="jazebeha.php" class="btn btn-secondary">انصراف</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
