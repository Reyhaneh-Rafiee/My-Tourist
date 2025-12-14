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

$sql = "SELECT j-id as id, title, description, image-path as image FROM jazebe ORDER BY j-id DESC";
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