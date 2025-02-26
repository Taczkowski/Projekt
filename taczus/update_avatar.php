<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'Brak autoryzacji!']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['avatar'])) {
        // Zapisz ścieżkę do zdjęcia profilowego w bazie danych
        try {
            $stmt = $conn->prepare("UPDATE daneosobowe SET profile_picture = ? WHERE ID = ?");
            $stmt->bind_param("si", $data['avatar'], $_SESSION['user_id']);
            $stmt->execute();
            $stmt->close();

            // Zaktualizuj zdjęcie profilowe w sesji
            $_SESSION['profile_picture'] = $data['avatar'];

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Błąd zapisu: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Brak danych awatara.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Nieprawidłowe żądanie.']);
}
?>