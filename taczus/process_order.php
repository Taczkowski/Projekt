<?php
session_start();
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pobierz dane z formularza
    $fullname = $_POST['fullname'] ?? '';
    $address = $_POST['address'] ?? '';
    $city = $_POST['city'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $payment = $_POST['payment'] ?? 'cash';
    
    // Pobierz ID zalogowanego użytkownika
    $user_id = $_SESSION['user_id'] ?? 0;
    
    // Pobierz koszyk z sesji
    $cart = $_SESSION['cart'] ?? [];
    
    if (!empty($cart) && $user_id > 0) {
        try {
            // Rozpocznij transakcję
            $conn->begin_transaction();
            
            // 1. Dodaj zamówienie do tabeli zamowienia
            $stmt = $conn->prepare("INSERT INTO zamowienia (id_uzytkownika, imie_nazwisko, adres, miasto, telefon, email, metoda_platnosci) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssss", $user_id, $fullname, $address, $city, $phone, $email, $payment);
            $stmt->execute();
            $order_id = $conn->insert_id;
            
            // 2. Dodaj szczegóły zamówienia
            $stmt_details = $conn->prepare("INSERT INTO zamowienia_szczegoly (id_zamowienia, nazwa_pizzy, skladniki, cena, ilosc) 
                                          VALUES (?, ?, ?, ?, ?)");
            
            foreach ($cart as $item) {
                $ingredients_json = json_encode($item['ingredients']);
                $stmt_details->bind_param("issdi", $order_id, $item['name'], $ingredients_json, $item['price'], $item['quantity']);
                $stmt_details->execute();
            }
            
            // Zakończ transakcję
            $conn->commit();
            
            // Wyczyść koszyk
            unset($_SESSION['cart']);
            
            // Przekieruj do main.php
            header("Location: main.php?order_success=1");
            exit();
            
        } catch (Exception $e) {
            // Cofnij transakcję w przypadku błędu
            $conn->rollback();
            header("Location: summary.php?error=1");
            exit();
        }
    } else {
        header("Location: summary.php?error=2");
        exit();
    }
} else {
    header("Location: summary.php");
    exit();
}