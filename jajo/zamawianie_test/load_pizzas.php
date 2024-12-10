<?php
$host = 'localhost';
$dbname = 'pdiddypizza';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}

$jsonFile = 'pizzas.json';
$jsonData = file_get_contents($jsonFile);
$pizzas = json_decode($jsonData, true);

if (!$pizzas) {
    die("Błąd wczytywania danych JSON.");
}

foreach ($pizzas as $pizza) {
    $name = $conn->real_escape_string($pizza['Nazwaproduktu']);
    $price = $pizza['Cena'];

    $sql = "INSERT INTO produkty (Nazwaproduktu, Cena) VALUES ('$name', $price)";
    if ($conn->query($sql) === TRUE) {
        echo "Dodano produkt: $name za $price zł<br>";
    } else {
        echo "Błąd: " . $conn->error . "<br>";
    }
}

$conn->close();
?>
