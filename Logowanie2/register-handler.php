<?php
$host = 'localhost';
$dbname = 'pdiddypizza';
$username = 'root'; 
$password = ''; 

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

$user = $_POST['username'];
$email = $_POST['email'];
$pass = $_POST['password'];

$user = $conn->real_escape_string($user);
$email = $conn->real_escape_string($email);

$sql_check = "SELECT * FROM konta WHERE Login = '$user' OR Email = '$email'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    echo "Użytkownik o podanej nazwie użytkownika lub e-mailu już istnieje.";
} else {
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    $sql_insert = "INSERT INTO konta (Login, Passwd, Email) VALUES ('$user', '$hashed_password', '$email')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "Rejestracja zakończona sukcesem! Możesz się teraz zalogować.";
    } else {
        echo "Błąd podczas rejestracji: " . $conn->error;
    }
}

$conn->close();
?>