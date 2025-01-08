<?php
session_start(); // Rozpoczęcie sesji

// Tymczasowe ustawienie użytkownika z ID 2 na potrzeby testów
$_SESSION['user_id'] = 3; // Zakłada, że użytkownik o ID 2 jest zalogowany

// Połączenie z bazą danych
$conn = new mysqli("localhost", "root", "", "pdiddypizza");

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Pobieranie danych z formularza
$imie = $_POST['imie'];
$nazwisko = $_POST['nazwisko'];
$miasto = $_POST['miasto'];
$ulica = $_POST['ulica'];
$telefon = $_POST['telefon'];
$email = $_POST['email'];

// ID aktualnie zalogowanego użytkownika z sesji
$user_id = $_SESSION['user_id'];

// Sprawdzenie, czy dane użytkownika już istnieją w tabeli `daneosobowe`
$sql_check = "SELECT * FROM daneosobowe WHERE ID = ?";
echo $sql_check; // Debugowanie zapytania SELECT
$stmt = $conn->prepare($sql_check);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Jeśli dane istnieją, aktualizujemy
    $sql_update = "UPDATE daneosobowe SET Imie = ?, Nazwisko = ?, miejscowosc = ?, ulica = ?, numertelefonu = ?, Email = ? WHERE ID = ?";
    echo $sql_update; // Debugowanie zapytania UPDATE
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("sssssis", $imie, $nazwisko, $miasto, $ulica, $telefon, $email, $user_id);
} else {
    // Jeśli dane nie istnieją, wstawiamy nowe
    $sql_insert = "INSERT INTO daneosobowe (ID, Imie, Nazwisko, miejscowosc, ulica, numertelefonu, Email) VALUES (?, ?, ?, ?, ?, ?, ?)";
    echo $sql_insert; // Debugowanie zapytania INSERT
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("issssis", $user_id, $imie, $nazwisko, $miasto, $ulica, $telefon, $email);
}

if ($stmt->execute()) {
    echo "Dane zostały zapisane.";
} else {
    echo "Błąd: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
