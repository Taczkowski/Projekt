<?php
$host = 'localhost';
$dbname = 'pdiddypizza';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

$user_or_email = $_POST['username_email'];
$pass = $_POST['password'];

$user_or_email = $conn->real_escape_string($user_or_email);

$sql = "SELECT * FROM konta WHERE Login = '$user_or_email' OR Email = '$user_or_email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashed_password = $row['Passwd'];

    if (password_verify($pass, $hashed_password)) {
        echo "Zalogowano pomyślnie! Witaj, " . $row['Login'] . ".";
    } else {
        echo "Błędna nazwa użytkownika lub hasło.";
    }
} else {
    echo "Błędna nazwa użytkownika lub hasło.";
}

$conn->close();
?>