<?php
session_start();

$host = 'localhost';
$dbname = 'pdiddypizza';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

$user = $_POST['Login'];
$pass = $_POST['Passwd'];

$user = $conn->real_escape_string($user);

$sql = "SELECT * FROM konta WHERE Login = '$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($pass, $row['Passwd'])) {
        $_SESSION['user_id'] = $row['ID'];
        $_SESSION['username'] = $row['Login'];
        header("Location: order.php");
        exit();
    } else {
        echo "Błędne hasło.";
    }
} else {
    echo "Błędny login.";
}

$conn->close();
?>
