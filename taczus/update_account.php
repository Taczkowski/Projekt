<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    die("Brak autoryzacji! Zaloguj się ponownie.");
}

$user_id = $_SESSION['user_id'];

// Pobierz dane z formularza
$fields = [
    'Imie' => $_POST['imie'] ?? null,
    'Nazwisko' => $_POST['nazwisko'] ?? null,
    'miejscowosc' => $_POST['miasto'] ?? null,
    'ulica' => $_POST['ulica'] ?? null,
    'numertelefonu' => $_POST['telefon'] ?? null,
    'Email' => $_POST['email'] ?? null
];

// Walidacja emaila (jeśli został przesłany)
if ($fields['Email'] && !filter_var($fields['Email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Nieprawidłowy format emaila!";
    header("Location: konto.php");
    exit();
}

// Przygotuj zapytanie SQL do aktualizacji tylko przesłanych pól
$sql = "UPDATE daneosobowe SET ";
$params = [];
$types = "";

foreach ($fields as $key => $value) {
    if ($value !== null) {
        $sql .= "$key = ?, ";
        $params[] = $value;
        $types .= "s"; // Wszystkie pola są typu string
    }
}

// Usuń ostatni przecinek i spację
$sql = rtrim($sql, ", ");

// Dodaj warunek WHERE
$sql .= " WHERE ID = ?";
$params[] = $user_id;
$types .= "i"; // ID jest typu integer

// Wykonaj zapytanie
try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $stmt->close();

    $_SESSION['success'] = "Dane zostały zaktualizowane!";
} catch (Exception $e) {
    $_SESSION['error'] = "Błąd podczas aktualizacji danych: " . $e->getMessage();
} finally {
    $conn->close();
    header("Location: konto.php");
    exit();
}
?>