<?php
// orders.php در پوشه panel-admin/
$host = "localhost";
$username = "root";
$password = "";
$dbname = "my_tourist_db";

// ایجاد اتصال
$conn = mysqli_connect($host, $username, $password, $dbname);

// بررسی اتصال
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");
?>
<!DOCTYPE html>
<html lang="fa">
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
                <a href="index.html">پیشخوان</a>
                <a href="../index.html">مشاهده سایت</a>
                <a href="add-new-tour.html">تور جدید</a>
                <a href="orders.php">سفارشات تور</a>
                <a href="add-new-jazebe.html">جاذبه جدید</a>
                <a href="jazebeha.html">جاذبه ها</a>
                <a href="../php/logout.php">خروج</a>
            </div>
        </div>
        
        <div class="col-10">
            <div class="card mb-3">
                <div class="card-header">
                    سفارشات
                </div>
                <form action="orders.html" method="get">
                    <div class="input-group">
                        <input style="direction: rtl;" type="text" placeholder="جستجو..." name="search" class="form-control text-end">
                        <button class="btn btn-primary" name="search-btn">جستجو</button>
                    </div>
                </form>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table float-right" style="direction: rtl">
                            <thead>
                                <tr>
                                    <th>ردیف</th>
                                    <th>نام</th>
                                    <th>شماره تماس</th>
                                    <th>ایمیل</th>
                                    <th>آدرس</th>
                                    <th>کد ملی</th>
                                    <th>تور خریداری شده</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // بررسی اگر جستجو وجود دارد
                                $search = isset($_GET['search']) ? $_GET['search'] : '';
                                
                                // ساخت کوئری بر اساس جستجو
                                if (!empty($search)) {
                                    $sql = "SELECT * FROM orders 
                                            WHERE name LIKE '%$search%' 
                                            OR email LIKE '%$search%' 
                                            OR phone LIKE '%$search%'
                                            OR code LIKE '%$search%'
                                            ORDER BY o_id DESC";
                                } else {
                                    $sql = "SELECT * FROM orders ORDER BY o_id DESC";
                                }
                                
                                $result = mysqli_query($conn, $sql);
                                
                                if ($result && mysqli_num_rows($result) > 0) {
                                    $counter = 1;
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $counter . "</td>";
                                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['code']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['t_id']) . "</td>";
                                        echo "<td>";
                                        echo "<a href='delete_order.php?id=" . $row['o_id'] . "' class='btn btn-danger' onclick='return confirm(\"آیا مطمئن هستید؟\")'>حذف</a>";
                                        echo "</td>";
                                        echo "</tr>";
                                        $counter++;
                                    }
                                } else {
                                    echo "<tr><td colspan='8' class='text-center'>هیچ سفارشی یافت نشد</td></tr>";
                                }
                                
                                mysqli_close($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>