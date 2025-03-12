<?php
session_start();
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Pobierz dane z formularza
        $id_uzytkownika = $_SESSION['user_id']; // ID użytkownika z sesji
        $imie_nazwisko = $_POST['fullname'];
        $adres = $_POST['address'];
        $miasto = $_POST['city'];
        $telefon = $_POST['phone'];
        $email = $_POST['email'];
        $metoda_platnosci = $_POST['payment'];

        // Pobierz dane z koszyka z sesji
        $koszyk = $_SESSION['cart'];

        // Wstaw dane zamówienia do tabeli zamowienia
        $stmt = $conn->prepare("
            INSERT INTO zamowienia (
                id_uzytkownika, 
                imie_nazwisko, 
                adres, 
                miasto, 
                telefon, 
                email, 
                metoda_platnosci
            ) VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "issssss", 
            $id_uzytkownika, 
            $imie_nazwisko, 
            $adres, 
            $miasto, 
            $telefon, 
            $email, 
            $metoda_platnosci
        );

        if ($stmt->execute()) {
            // Pobierz automatycznie wygenerowane id_zamowienia
            $id_zamowienia = $stmt->insert_id;

            // Przygotuj zapytanie SQL do wstawienia danych do tabeli zamowienia_szczegoly
            $stmtSzczegoly = $conn->prepare("
                INSERT INTO zamowienia_szczegoly (
                    id_zamowienia, 
                    nazwa_pizzy, 
                    skladniki, 
                    cena, 
                    ilosc
                ) VALUES (?, ?, ?, ?, ?)
            ");

            // Przetwórz każdą pozycję w koszyku
            foreach ($koszyk as $item) {
                $nazwa_pizzy = $item['name']; // Nazwa pizzy
                $skladniki = json_encode($item['ingredients'] ?? []); // Składniki pizzy jako JSON
                $cena = $item['price']; // Cena za daną pozycję
                $ilosc = $item['quantity'] ?? 1; // Ilość danej pizzy

                // Wykonaj zapytanie dla każdej pozycji w koszyku
                $stmtSzczegoly->bind_param(
                    "issdi", 
                    $id_zamowienia, 
                    $nazwa_pizzy, 
                    $skladniki, 
                    $cena, 
                    $ilosc
                );

                if (!$stmtSzczegoly->execute()) {
                    throw new Exception("Błąd podczas zapisywania szczegółów zamówienia: " . $stmtSzczegoly->error);
                }
            }

            // Jeśli zamówienie zostało pomyślnie zapisane, wyczyść koszyk
            unset($_SESSION['cart']); // Usuń koszyk z sesji

            // Przekieruj użytkownika do strony main.php
            header('Location: main.php');
            exit();
        } else {
            throw new Exception("Błąd podczas zapisywania zamówienia: " . $stmt->error);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Błąd serwera: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Nieprawidłowe żądanie.']);
}