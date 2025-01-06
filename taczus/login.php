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

// Odbieranie danych z formularza logowania
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Walidacja danych
    if (empty($username) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Wszystkie pola muszą być wypełnione."]);
        exit();
    }

    // Zapytanie SQL do sprawdzenia, czy użytkownik istnieje
    $sql = "SELECT ID, Login, Passwd FROM konta WHERE Login = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Jeśli użytkownik istnieje, porównujemy hasła
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['Passwd'])) {
            echo json_encode(["status" => "success", "message" => "Zalogowano pomyślnie!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Nieprawidłowe hasło."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Użytkownik nie istnieje."]);
    }
}

// Zamknięcie połączenia z bazą danych
$conn->close();
?>
