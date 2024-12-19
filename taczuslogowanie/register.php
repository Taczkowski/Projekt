<?php
// register.php

// Połączenie z bazą danych
$host = "localhost";
$username = "root"; // Zmień na odpowiednią nazwę użytkownika bazy danych
$password = ""; // Zmień na odpowiednie hasło bazy danych
$dbname = "pdiddypizza";

$conn = new mysqli($host, $username, $password, $dbname);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['username'];
    $email = $_POST['email'];
    $passwd = $_POST['password'];

    // Sprawdzenie, czy użytkownik już istnieje
    $sql = "SELECT * FROM konta WHERE Login = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Użytkownik już istnieje"]);
    } else {
        // Szyfrowanie hasła
        $hashed_password = password_hash($passwd, PASSWORD_BCRYPT);

        // Wstawienie nowego użytkownika do bazy danych
        $insert_sql = "INSERT INTO konta (Login, Passwd, Email) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sss", $login, $hashed_password, $email);
        $stmt->execute();

        echo json_encode(["status" => "success", "message" => "Rejestracja zakończona sukcesem"]);
    }

    $stmt->close();
    $conn->close();
}
?>
