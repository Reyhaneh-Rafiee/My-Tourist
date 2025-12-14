<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_tourist_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['type']) && isset($_GET['id'])) {
    $type = $_GET['type'];
    $id = intval($_GET['id']);
    
    if ($type == 'tour') {
        $sql = "DELETE FROM tours WHERE t-id = ?";
    } elseif ($type == 'jazebe') {
        $sql = "DELETE FROM jazebe WHERE j-id = ?";
    } else {
        header("Location: ../panel-admin/index.php");
        exit();
    }
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: ../panel-admin/index.php?msg=deleted");
    } else {
        echo "خطا در حذف";
    }
    
    $stmt->close();
} else {
    header("Location: ../panel-admin/index.php");
}

$conn->close();
?>