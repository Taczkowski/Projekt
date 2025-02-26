<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    die("Brak autoryzacji! Zaloguj się ponownie.");
}

$user_id = $_SESSION['user_id'];

// Pobierz dane użytkownika z bazy danych
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

// Pobierz ścieżkę do zdjęcia profilowego
$profile_picture = $existing_data['profile_picture'] ?? './assets/avatar.png';

// Sprawdź, czy użytkownik edytuje dane po raz pierwszy
$is_first_edit = empty($existing_data);

// Ustaw domyślne wartości dla pól formularza
$fields = [
    'Imie' => $existing_data['Imie'] ?? '',
    'Nazwisko' => $existing_data['Nazwisko'] ?? '',
    'miejscowosc' => $existing_data['miejscowosc'] ?? '',
    'ulica' => $existing_data['ulica'] ?? '',
    'numertelefonu' => $existing_data['numertelefonu'] ?? '',
    'Email' => $existing_data['Email'] ?? ''
];

// Wyświetl komunikaty o sukcesie lub błędzie
if (isset($_SESSION['success'])) {
    echo '<div class="success-message">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona Konta</title>
    <link rel="stylesheet" href="falling-ingredients.css">
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="snowflakes"></div>

    <header>
        <div class="logo-container">
            <h2>P.DIDDY PIZZA</h2>
        </div>
    </header>

    <div class="navbar">
        <!-- Ikona profilowego -->
        <div class="avatar" id="avatar">
            <img src="<?= $profile_picture ?>" alt="Avatar">
        </div>
        <button class="nav-btn" onclick="window.location.href='main.php'">← Powrót do menu</button>
        <button class="nav-btn" data-section="promocje">Kody Promocyjne</button>
        <button class="nav-btn" onclick="window.location.href='ostatnie_zamowienia.php'">Ostatnie Zamówienia</button>
    </div>

    <main>
        <div id="central-div" class="rounded-box">
            <h2>Witamy na stronie konta</h2>

            <form method="POST" action="update_account.php">
                <label>Imię: 
                    <input type="text" class="input" name="imie" value="<?= $fields['Imie'] ?>" <?= $is_first_edit ? 'required' : '' ?>>
                </label><br>
                <label>Nazwisko: 
                    <input type="text" class="input" name="nazwisko" value="<?= $fields['Nazwisko'] ?>" <?= $is_first_edit ? 'required' : '' ?>>
                </label><br>
                <label>Miejscowość: 
                    <input type="text" class="input" name="miasto" value="<?= $fields['miejscowosc'] ?>" <?= $is_first_edit ? 'required' : '' ?>>
                </label><br>
                <label>Ulica: 
                    <input type="text" class="input" name="ulica" value="<?= $fields['ulica'] ?>" <?= $is_first_edit ? 'required' : '' ?>>
                </label><br>
                <label>Numer telefonu: 
                    <input type="text" class="input" name="telefon" value="<?= $fields['numertelefonu'] ?>" <?= $is_first_edit ? 'required' : '' ?>>
                </label><br>
                <label>Email: 
                    <input type="email" class="input" name="email" value="<?= $fields['Email'] ?>" required>
                </label><br>
                <button type="submit">Zapisz zmiany</button>
            </form>
        </div>
    </main>

    <!-- Okienko do wyboru awatara -->
    <div id="avatar-popup" class="hidden">
        <div class="popup-content">
            <h3>Wybierz avatar</h3>
            <img src="./assets/avatar1.png" alt="Avatar 1" class="avatar-option" data-avatar="./assets/avatar1.png">
            <img src="./assets/avatar2.png" alt="Avatar 2" class="avatar-option" data-avatar="./assets/avatar2.png">
            <img src="./assets/avatar3.png" alt="Avatar 3" class="avatar-option" data-avatar="./assets/avatar3.png">
        </div>
    </div>

    <script src="falling-ingredients.js"></script>
    <script src="account.js" defer></script>
</body>
</html>