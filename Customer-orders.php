<?php
require_once 'pages/config.php';

if (!isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$user_id = getCurrentUser(); // گرفتن شناسه کاربر از سشن

// پیام موفقیت لغو
$cancel_msg = isset($_GET['msg']) ? $_GET['msg'] : '';

// جستجو
$search = isset($_GET['search']) ? "%".trim($_GET['search'])."%" : "%";
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>سفارشات مشتری</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .table th { background-color: #2c3e50; color: white; text-align: center; }
        .table td { text-align: center; vertical-align: middle; }
        .no-orders { text-align: center; padding: 50px; color: #7f8c8d; font-size: 18px; }
        .search-box { margin: 20px 0; }
        .action-buttons .btn { margin: 2px; font-size: 12px; padding: 5px 10px; }
    </style>
</head>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // همه td های ستون قیمت (ستون 7)
    const priceCells = document.querySelectorAll("table tbody tr td:nth-child(7)");
    priceCells.forEach(cell => {
        let value = cell.innerText.trim();
        if (!isNaN(value) && value !== "") {
            let formatted = Number(value).toLocaleString("fa-IR");
            cell.innerText = formatted + " تومان";
        }
    });
});
</script>

<body>
<nav class="nav top-bar">
    <h2 class="float-left">سفارش ها</h2>
</nav>

<div class="card mb-3">
    <div class="card-header">سفارشات مشتری</div>
    <form action="Customer-orders.php" method="get" class="p-3">
        <div class="input-group">
            <input type="text" placeholder="جستجو در سفارشات..." name="search" 
                   class="form-control text-end" 
                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button class="btn btn-primary" type="submit">جستجو</button>
        </div>
    </form>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table float-right" style="direction: rtl">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>شماره سفارش</th>
                    <th>نام مشتری</th>
                    <th>نام تور</th>
                    <th>تاریخ سفر</th>
                    <th>تعداد مسافر</th>
                    <th>قیمت کل</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
<?php
// دریافت سفارش‌های کاربر با JOIN روی تورها
$sql = "SELECT o.o_id, o.name AS customer_name, t.title AS tour_name, o.travel_date, o.travelers, o.total_price, o.status
        FROM orders o
        INNER JOIN tours t ON o.t_id = t.t_id
        WHERE o.user_id = ? AND (t.title LIKE ? OR o.name LIKE ?)
        ORDER BY o.travel_date DESC";

$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "iss", $user_id, $search, $search);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if($result && mysqli_num_rows($result) > 0){
    $row_number = 1;
    while($row = mysqli_fetch_assoc($result)){
        echo "<tr>";
        echo "<td>".$row_number."</td>";
        echo "<td>".$row['o_id']."</td>";
        echo "<td>".htmlspecialchars($row['customer_name'])."</td>";
        echo "<td>".htmlspecialchars($row['tour_name'])."</td>";
        echo "<td>".htmlspecialchars($row['travel_date'])."</td>";
        echo "<td>".$row['travelers']."</td>";
        echo "<td>".$row['total_price']."</td>";
        echo "<td>".htmlspecialchars($row['status'])."</td>";
        
        // دکمه لغو فقط اگر وضعیت paid باشد
        echo "<td>";
        if($row['status'] === 'paid'){
            echo '<a href="cancel-order.php?id='.$row['o_id'].'" class="btn btn-danger btn-sm"
                  onclick="return confirm(\'آیا مطمئن هستید می‌خواهید این سفارش را لغو کنید؟\');">
                  لغو سفارش</a>';
        } else {
            echo "-";
        }
        echo "</td>";
        echo "</tr>";
        $row_number++;
    }
} else {
    echo "<tr><td colspan='9' class='no-orders'>شما هنوز سفارشی ثبت نکرده‌اید.</td></tr>";
}

mysqli_stmt_close($stmt);
?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<button class="btn btn-primary float-end" onclick="window.location.href='index.php'">بازگشت</button>

<!-- Toast پیام لغو سفارش -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="cancelToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <?php echo htmlspecialchars($cancel_msg); ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const cancelMsg = "<?php echo $cancel_msg; ?>";
    if(cancelMsg !== ''){
        var toastEl = document.getElementById('cancelToast');
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
    }
});
</script>
</body>
</html>
