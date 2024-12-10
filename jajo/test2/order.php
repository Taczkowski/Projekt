<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$host = 'localhost';
$dbname = 'pdiddypizza';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

$sql = "SELECT * FROM produkty";
$result = $conn->query($sql);
$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $productId = $_POST['product_id'];
    $price = $_POST['price'];

    $productId = $conn->real_escape_string($productId);
    $price = $conn->real_escape_string($price);

    $sql = "INSERT INTO zamowienia (IDkonta, IDproduktu, Cena, Zrealizowano) VALUES ('$userId', '$productId', '$price', 0)";
    if ($conn->query($sql) === TRUE) {
        echo "Zamówienie zostało złożone!";
    } else {
        echo "Błąd: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zamówienia</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Witaj, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <a href="logout.php">Wyloguj się</a>

    <h2>Wybierz produkt:</h2>
    <form action="order.php" method="POST">
        <select name="product_id" id="product_id" required>
            <?php foreach ($products as $product): ?>
                <option value="<?php echo $product['IDproduktu']; ?>" data-price="<?php echo $product['Cena']; ?>">
                    <?php echo htmlspecialchars($product['Nazwaproduktu']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <div id="product_details">
            <p><strong>Nazwa produktu:</strong> <span id="product_name"></span></p>
            <p><strong>Cena:</strong> <span id="product_price"></span> zł</p>
        </div>

        <input type="hidden" name="price" id="hidden_price" required>

        <button type="submit">Zamów</button>
    </form>

    <script>
        document.getElementById('product_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var productName = selectedOption.text;
            var productPrice = selectedOption.getAttribute('data-price');

            document.getElementById('product_name').textContent = productName;
            document.getElementById('product_price').textContent = productPrice;

            document.getElementById('hidden_price').value = productPrice;
        });

        window.onload = function() {
            var defaultOption = document.getElementById('product_id').options[0];
            var productName = defaultOption.text;
            var productPrice = defaultOption.getAttribute('data-price');

            document.getElementById('product_name').textContent = productName;
            document.getElementById('product_price').textContent = productPrice;
            document.getElementById('hidden_price').value = productPrice;
        };
    </script>
</body>
</html>
