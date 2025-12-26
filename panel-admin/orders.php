<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>پنل مدیریت - سفارشات</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .table th {
            background-color: #2c3e50;
            color: white;
            text-align: center;
        }
        
        .table td {
            text-align: center;
            vertical-align: middle;
        }
        
        .no-orders {
            text-align: center;
            padding: 50px;
            color: #7f8c8d;
            font-size: 18px;
        }
        
        .search-box {
            margin: 20px 0;
        }
        
        .action-buttons .btn {
            margin: 2px;
            font-size: 12px;
            padding: 5px 10px;
        }
    </style>
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
            <div class="card mb-3">
                <div class="card-header">
                    سفارشات تور
                </div>
                
                <!-- فرم جستجو -->
                <form action="orders.php" method="get" class="p-3">
                    <div class="input-group">
                        <input type="text" placeholder="جستجو در سفارشات..." name="search" 
                               class="form-control text-end" 
                               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <button class="btn btn-primary" type="submit">جستجو</button>
                    </div>
                </form>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" style="direction: rtl">
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
                                // بخش PHP برای اتصال به دیتابیس و نمایش داده‌ها
                                // اتصال به دیتابیس
                                $servername = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "my_tourist_db";
                                
                                $conn = new mysqli($servername, $username, $password, $dbname);
                                
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }
                                
                                $conn->set_charset("utf8");
                                
                                // دریافت پارامتر جستجو
                                $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
                                
                                // ساخت کوئری
                                $sql = "SELECT orders.*, tours.title as tour_title 
                                        FROM orders 
                                        LEFT JOIN tours ON orders.t_id = tours.t_id";
                                
                                if (!empty($search)) {
                                    $sql .= " WHERE orders.name LIKE '%$search%' 
                                             OR orders.email LIKE '%$search%' 
                                             OR orders.phone LIKE '%$search%'
                                             OR orders.code LIKE '%$search%'
                                             OR tours.title LIKE '%$search%'";
                                }
                                
                                $sql .= " ORDER BY orders.o_id DESC";
                                
                                $result = $conn->query($sql);
                                
                                if ($result && $result->num_rows > 0) {
                                    $counter = 1;
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $counter . "</td>";
                                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                        echo "<td>" . htmlspecialchars(substr($row['address'], 0, 30)) . "...</td>";
                                        echo "<td>" . htmlspecialchars($row['code']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['tour_title'] ?? 'ناشناخته') . "</td>";
                                        echo "<td>";
                                        echo "<div class='action-buttons'>";
                                        echo "<a href='delete-order.php?id=" . $row['o_id'] . "' class='btn btn-danger btn-sm' 
                                               onclick='return confirm(\"آیا از حذف این سفارش مطمئن هستید؟\")'>حذف</a>";
                                        echo "</div>";
                                        echo "</td>";
                                        echo "</tr>";
                                        $counter++;
                                    }
                                } else {
                                    echo "<tr>";
                                    echo "<td colspan='8' class='no-orders'>";
                                    if (!empty($search)) {
                                        echo "<p>هیچ سفارشی با این مشخصات یافت نشد</p>";
                                    } else {
                                        echo "<p>هنوز هیچ سفارشی ثبت نشده است</p>";
                                    }
                                    echo "</td>";
                                    echo "</tr>";
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

<!-- اسکریپت برای نمایش آدرس کامل -->
<script>
$(document).ready(function() {
    // نمایش آدرس کامل در hover
    $('td:nth-child(5)').hover(function() {
        var fullAddress = $(this).data('full-address');
        if (fullAddress) {
            $(this).attr('title', fullAddress);
        }
    });
    
    // فرمت شماره تلفن
    $('td:nth-child(3)').each(function() {
        var phone = $(this).text().trim();
        if (phone) {
            // فرمت: 0912-123-4567
            var formatted = phone.replace(/(\d{4})(\d{3})(\d{4})/, '$1-$2-$3');
            $(this).text(formatted);
        }
    });
});
</script>
</body>
</html>