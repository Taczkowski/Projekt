<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    die("Brak autoryzacji! Zaloguj się ponownie.");
}

$user_id = $_SESSION['user_id'];

$existing_data = [];
try {
    $stmt = $conn->prepare("SELECT * FROM daneosobowe WHERE ID = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $existing_data = $result->fetch_assoc();
    }
    $stmt->close();
} catch (Exception $e) {
    die("Błąd przy pobieraniu danych: " . $e->getMessage());
}

$fields = [
    'Imie' => $_POST['imie'] ?? $existing_data['Imie'] ?? '',
    'Nazwisko' => $_POST['nazwisko'] ?? $existing_data['Nazwisko'] ?? '',
    'miejscowosc' => $_POST['miasto'] ?? $existing_data['miejscowosc'] ?? '',
    'ulica' => $_POST['ulica'] ?? $existing_data['ulica'] ?? '',
    'numertelefonu' => $_POST['telefon'] ?? $existing_data['numertelefonu'] ?? '',
    'Email' => $_POST['email'] ?? $existing_data['Email'] ?? ''
];

$fields['numertelefonu'] = preg_replace('/[^0-9]/', '', $fields['numertelefonu']);
if (!filter_var($fields['Email'], FILTER_VALIDATE_EMAIL)) {
    die("Nieprawidłowy format emaila!");
}

try {
    if (isset($existing_data['ID'])) {
        $sql = "UPDATE daneosobowe SET 
                Imie = ?,
                Nazwisko = ?,
                miejscowosc = ?,
                ulica = ?,
                numertelefonu = ?,
                Email = ?
                WHERE ID = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssssi",
            $fields['Imie'],
            $fields['Nazwisko'],
            $fields['miejscowosc'],
            $fields['ulica'],
            $fields['numertelefonu'],
            $fields['Email'],
            $user_id
        );
    } else {
        $sql = "INSERT INTO daneosobowe 
                (ID, Imie, Nazwisko, miejscowosc, ulica, numertelefonu, Email)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "issssss",
            $user_id,
            $fields['Imie'],
            $fields['Nazwisko'],
            $fields['miejscowosc'],
            $fields['ulica'],
            $fields['numertelefonu'],
            $fields['Email']
        );
    }

    if ($stmt->execute()) {
        $_SESSION['success'] = "Dane zostały zapisane!";
    } else {
        $_SESSION['error'] = "Błąd zapisu: " . $stmt->error;
    }
    
    $stmt->close();
} catch (Exception $e) {
    $_SESSION['error'] = "Błąd systemowy: " . $e->getMessage();
} finally {
    $conn->close();
    header("Location: konto.php");
    exit();
}