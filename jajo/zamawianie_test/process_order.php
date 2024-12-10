<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'pdiddypizza';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Błąd połączenia z bazą danych']));
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['IDproduktu'])) {
    echo json_encode(['status' => 'error', 'message' => 'Nie podano ID produktu']);
    exit;
}

$productId = $data['IDproduktu'];
$userId = 1;

$sql = "INSERT INTO zamowienia (IDkonta, IDproduktu, Cena) 
        SELECT $userId, IDproduktu, 0 FROM produkty WHERE IDproduktu = $productId";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Zamówienie zostało złożone!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Błąd przy składaniu zamówienia: ' . $conn->error]);
}

$conn->close();
?>
