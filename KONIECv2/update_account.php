<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['status' => 'error', 'message' => 'Brak autoryzacji']));
}

$user_id = $_SESSION['user_id'];

// Pobierz dane z formularza
$data = [
    'Imie' => $_POST['imie'] ?? null,
    'Nazwisko' => $_POST['nazwisko'] ?? null,
    'miejscowosc' => $_POST['miasto'] ?? null,
    'ulica' => $_POST['ulica'] ?? null,
    'numertelefonu' => $_POST['telefon'] ?? null,
    'Email' => $_POST['email'] ?? null
];

// Walidacja danych
$errors = [];

if ($data['Email'] && !filter_var($data['Email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Nieprawidłowy format emaila";
}

if ($data['numertelefonu'] && !preg_match('/^[0-9]{9}$/', $data['numertelefonu'])) {
    $errors[] = "Numer telefonu musi składać się z 9 cyfr";
}

if (!empty($errors)) {
    $_SESSION['error'] = implode("<br>", $errors);
    header("Location: konto.php");
    exit;
}

try {
    // Sprawdź czy użytkownik ma już dane osobowe
    $check = $conn->prepare("SELECT ID FROM daneosobowe WHERE ID = ?");
    $check->bind_param("i", $user_id);
    $check->execute();
    $exists = $check->get_result()->num_rows > 0;
    $check->close();

    if ($exists) {
        // Aktualizacja istniejących danych
        $sql = "UPDATE daneosobowe SET ";
        $params = [];
        $types = "";
        
        foreach ($data as $field => $value) {
            if ($value !== null) {
                $sql .= "$field = ?, ";
                $params[] = $value;
                $types .= "s";
            }
        }
        
        $sql = rtrim($sql, ", ") . " WHERE ID = ?";
        $params[] = $user_id;
        $types .= "i";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $stmt->close();
        
        $_SESSION['success'] = "Dane zostały zaktualizowane!";
    } else {
        // Wstaw nowe dane (INSERT)
        $fields = [];
        $placeholders = [];
        $params = [];
        $types = "";
        
        foreach ($data as $field => $value) {
            if ($value !== null) {
                $fields[] = $field;
                $placeholders[] = "?";
                $params[] = $value;
                $types .= "s";
            }
        }
        
        // Dodaj ID użytkownika
        $fields[] = "ID";
        $placeholders[] = "?";
        $params[] = $user_id;
        $types .= "i";
        
        $sql = "INSERT INTO daneosobowe (" . implode(", ", $fields) . ") 
                VALUES (" . implode(", ", $placeholders) . ")";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $stmt->close();
        
        $_SESSION['success'] = "Dane zostały zapisane!";
    }
    
} catch (Exception $e) {
    $_SESSION['error'] = "Błąd podczas zapisywania danych: " . $e->getMessage();
} finally {
    $conn->close();
    header("Location: konto.php");
    exit;
}