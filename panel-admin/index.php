<?php
session_start();
if(isset($_SESSION['message']) && !empty($_SESSION['message'])){
    $type = $_SESSION['message_type'] ?? 'info'; // success, danger, warning
    $message = $_SESSION['message'];
    // پاک کردن سشن تا بعد از رفرش دوباره نیاد
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
    ?>
    <div id="notification" class="notification <?php echo $type; ?>">
        <span><?php echo $message; ?></span>
        <button id="okBtn">OK</button>
    </div>

    <style>
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #f0f0f0;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 250px;
        }
        .notification.success { background-color: #d4edda; color: #155724; }
        .notification.danger { background-color: #f8d7da; color: #721c24; }
        .notification.warning { background-color: #fff3cd; color: #856404; }

        #notification button {
            margin-left: auto;
            background: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        #notification button:hover {
            background: #0056b3;
        }
    </style>

    <script>
        document.getElementById('okBtn').addEventListener('click', function() {
            document.getElementById('notification').style.display = 'none';
        });
    </script>
<?php
}
?>


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
<script>
document.addEventListener("DOMContentLoaded", function() {
    // گرفتن همه سلول‌های ستون قیمت
    const priceCells = document.querySelectorAll('table.table tbody tr td:nth-child(4)');

    priceCells.forEach(function(cell){
        let value = cell.textContent.trim();
        // حذف "ریال" اگر وجود دارد
        value = value.replace(' ریال', '');
        value = value.replace(/,/g, '');
        
        if(!isNaN(value) && value !== ''){
            // جدا کردن سه رقم سه رقم
            let formatted = Number(value).toLocaleString('en-US');
            // قرار دادن متن سمت چپ با "ریال"
            cell.innerHTML = formatted + ' تومان';
        }
    });
});
</script>

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

          <form action="index.php" method="get">
                        <div class="input-group">
                            <input type="text" placeholder="search" name="search" class="form-control" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button class="btn btn-primary" name="search-btn">Go</button>
                        </div>
                    </form>
                <!-- table list -->
                <div class="card mb-3">
                    <div class="card-header">
                    لیست تور ها
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table float-right" style="direction: rtl">
                                <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>تصویر</th>
                                    <th>نام</th>
                                    <th>قیمت</th>
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
                                $sql = "SELECT * FROM tours";
                                
                                if (isset($_GET['search']) && !empty($_GET['search'])) {
                                    $search = $conn->real_escape_string($_GET['search']);
                                    $sql .= " WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
                                }
                                
                                $sql .= " ORDER BY t_id DESC";
                                
                                $result = $conn->query($sql);
                                
                                if ($result && $result->num_rows > 0) {
                                    $counter = 1;
                                    while($row = $result->fetch_assoc()) {
                                        $id = $row['t_id'];
                                        $title = htmlspecialchars($row['title']);
                                        $price = isset($row['price']) ? $row['price'] : 0;
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
                                            <td><?php echo number_format($price); ?></td>
                                              <td>
                                                <a href="edit-tour.php?id=<?php echo $id; ?>" class="btn btn-warning">ویرایش</a>
                                            </td>
                                            <td>
                                                <a href="delete-tour.php?id=<?php echo $id; ?>" class="btn btn-danger" onclick="return confirm('آیا از حذف این تور مطمئن هستید؟')">حذف</a>
                                            </td>
                                            
                                        </tr>
                                        <?php
                                        $counter++;
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 50px;">
                                            <p>هیچ توری یافت نشد.</p>
                                            <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
                                            <a href="index.php" class="btn btn-secondary">نمایش همه تورها</a>
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
            if (!confirm('آیا از حذف این تور مطمئن هستید؟')) {
                e.preventDefault();
            }
        });
    });
});
</script>
</body>
</html>
