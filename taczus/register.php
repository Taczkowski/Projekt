<?php
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Wszystkie pola wymagane"]);
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO konta (Login, Email, Passwd) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Konto utworzone!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Błąd: " . $stmt->error]);
    }
    $stmt->close();
}

$conn->close();
?>