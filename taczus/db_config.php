<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pdiddypizza";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed']));
}

$conn->set_charset("utf8mb4");
?>