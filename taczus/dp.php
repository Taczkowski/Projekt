<?php
$host = '127.0.0.1'; 
$dbname = 'pdiddypizza';
$username = 'root';  // Zmień na swoje dane logowania
$password = '';      // Zmień na swoje dane logowania

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Błąd połączenia: " . $e->getMessage();
    exit();
}
?>
