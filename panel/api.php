<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

$db = new PDO('mysql:host=localhost;dbname=pdiddypizza;charset=utf8mb4', 'root', '');

// Pobieranie zamówień
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $status = $_GET['status'] ?? 'nowe';
    
    // Pobierz podstawowe dane zamówienia
    $stmt = $db->prepare("
        SELECT z.*, SUM(zs.ilosc) as liczba_pizz
        FROM zamowienia z
        LEFT JOIN zamowienia_szczegoly zs ON z.id_zamowienia = zs.id_zamowienia
        WHERE z.status = ?
        GROUP BY z.id_zamowienia
        ORDER BY z.data_zamowienia DESC
    ");
    $stmt->execute([$status]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Dla każdego zamówienia pobierz szczegóły pizz
    foreach ($orders as &$order) {
        $stmt = $db->prepare("
            SELECT nazwa_pizzy, ilosc, skladniki 
            FROM zamowienia_szczegoly 
            WHERE id_zamowienia = ?
        ");
        $stmt->execute([$order['id_zamowienia']]);
        $order['szczegoly'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    echo json_encode($orders);
    exit;
}

// Aktualizacja statusu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update_status') {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['new_status'];
    
    $stmt = $db->prepare("UPDATE zamowienia SET status = ? WHERE id_zamowienia = ?");
    $stmt->execute([$newStatus, $orderId]);
    
    echo json_encode(['success' => true]);
    exit;
}

// Domyślna odpowiedź
echo json_encode(['error' => 'Nieznana akcja']);