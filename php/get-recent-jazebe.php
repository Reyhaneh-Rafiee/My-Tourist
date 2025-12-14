<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_tourist_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed']));
}

$conn->set_charset("utf8");

$sql = "SELECT `title`, `description`, `image-path` as image 
        FROM jazebe 
        ORDER BY `j-id` DESC 
        LIMIT 3";
$result = $conn->query($sql);

$jazebe = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $jazebe[] = $row;
    }
}

echo json_encode($jazebe);
$conn->close();
?>