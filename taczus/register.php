<?php
// Połączenie z bazą danych
$servername = "localhost";
$username = "root";  // Ustaw użytkownika bazy danych
$password = "";  // Ustaw hasło do bazy danych
$dbname = "pdiddypizza";  // Ustaw nazwę bazy danych

// Tworzenie połączenia
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Połączenie nieudane: " . $conn->connect_error);
}

// Odbieranie danych z formularza
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Walidacja danych
    if (empty($username) || empty($email) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Wszystkie pola muszą być wypełnione."]);
        exit();
    }

    // Haszowanie hasła
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Zapytanie SQL do zapisania danych w bazie
    $sql = "INSERT INTO konta (Login, Email, Passwd) VALUES ('$username', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Rejestracja zakończona sukcesem!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Błąd rejestracji: " . $conn->error]);
    }
}

// Zamknięcie połączenia z bazą danych
$conn->close();
?>
