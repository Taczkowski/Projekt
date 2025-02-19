<?php
session_start();
header('Content-Type: application/json');
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $stmt = $conn->prepare("SELECT ID, Login, Passwd FROM konta WHERE Login = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if(password_verify($password, $user['Passwd'])) {
                $_SESSION['user_id'] = $user['ID'];
                $_SESSION['username'] = $user['Login'];
                $a = $_SESSION['user_id'];
                echo json_encode(['status' => 'success', 'redirect' => 'main.php']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Nieprawidłowe hasło']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Użytkownik nie istnieje']);
        }
    } catch(Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Błąd serwera: '.$e->getMessage()]);
    }
}
?>