<?php
// login.php

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
    $passwd = $_POST['password'];

    // Sprawdzenie, czy użytkownik istnieje
    $sql = "SELECT * FROM konta WHERE Login = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Weryfikacja hasła
        if (password_verify($passwd, $user['Passwd'])) {
            echo json_encode(["status" => "success", "message" => "Zalogowano pomyślnie"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Błędne hasło"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Użytkownik nie istnieje"]);
    }
    $stmt->close();
    $conn->close();
}
?>
