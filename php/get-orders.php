<?php
// get_orders.php در پوشه panel-admin/
$host = "localhost";
$username = "root";
$password = "";
$dbname = "my_tourist_db";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed");
}

mysqli_set_charset($conn, "utf8");

$search = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($search)) {
    $sql = "SELECT * FROM orders 
            WHERE name LIKE '%$search%' 
            OR email LIKE '%$search%' 
            OR phone LIKE '%$search%'
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