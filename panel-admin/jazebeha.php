
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>admin panel</title>
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
                <a href="../index.php">مشاهده سایت</a>
                <a href="add-new-tour.html">تور جدید</a>
                <a href="orders.php">سفارشات تور</a>
                <a href="add-new-jazebe.html">جاذبه جدید</a>
                <a href="jazebeha.php">جاذبه ها</a>

                <a href="../php/logout.php">خروج</a>
            </div>
        </div>
        <div class="col-10">

          <form action="jazebeha.php" method="get">
                        <div class="input-group">
                            <input type="text" placeholder="search" name="search" class="form-control" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button class="btn btn-primary" name="search-btn">Go</button>
                        </div>
                    </form>
                <!-- table list -->
                <div class="card mb-3">
                    <div class="card-header">
                        لیست جاذبه ها
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table float-right" style="direction: rtl">
                                <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>تصویر</th>
                                    <th>نام</th>
                                    <th>ویرایش</th>
                                    <th>حذف</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
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
                                
                                // جستجو
                                $sql = "SELECT * FROM jazebe";
                                
                                if (isset($_GET['search']) && !empty($_GET['search'])) {
                                    $search = $conn->real_escape_string($_GET['search']);
                                    $sql .= " WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
                                }
                                
                                $sql .= " ORDER BY j_id DESC";
                                
                                $result = $conn->query($sql);
                                
                                if ($result && $result->num_rows > 0) {
                                    $counter = 1;
                                    while($row = $result->fetch_assoc()) {
                                        $id = $row['j_id'];
                                        $title = htmlspecialchars($row['title']);
                                        $image_path = $row['image_path'];
                                        
                                        // مسیر تصویر
                                        $image_src = "admin-images/default.jpg";
                                        if (!empty($image_path) && file_exists("../" . $image_path)) {
                                            $image_src = "../" . $image_path;
                                        } elseif (!empty($image_path)) {
                                            $image_src = $image_path;
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $counter; ?></td>
                                            <td><img src="<?php echo $image_src; ?>" width="100px" height="70px" onerror="this.src='admin-images/default.jpg'"></td>
                                            <td><?php echo $title; ?></td>
                                              <td>
                                                <a href="edit-jazebe.php?id=<?php echo $id; ?>" class="btn btn-warning">ویرایش</a>
                                            </td>
                                            <td>
                                                <a href="delete-jazebe.php?id=<?php echo $id; ?>" class="btn btn-danger" onclick="return confirm('آیا از حذف این جاذبه مطمئن هستید؟')">حذف</a>
                                            </td>
                                            
                                        </tr>
                                        <?php
                                        $counter++;
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="5" style="text-align: center; padding: 50px;">
                                            <p>هیچ جاذبه‌ای یافت نشد.</p>
                                            <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
                                            <a href="jazebeha.php" class="btn btn-secondary">نمایش همه جاذبه‌ها</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                
                                $conn->close();
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

<script>
// تایید حذف
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-danger');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('آیا از حذف این جاذبه مطمئن هستید؟')) {
                e.preventDefault();
            }
        });
    });
});
</script>
</body>
</html>
[file content end]