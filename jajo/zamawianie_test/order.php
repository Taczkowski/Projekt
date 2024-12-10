<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zamów pizzę</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Zamów pizzę</h1>
        <table>
            <thead>
                <tr>
                    <th>Nazwa pizzy</th>
                    <th>Cena</th>
                    <th>Akcja</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = new mysqli('localhost', 'root', '', 'pdiddypizza');
                if ($conn->connect_error) {
                    die("Błąd połączenia: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM produkty";
                $result = $conn->query($sql);

$sql = "SELECT * FROM produkty";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['Nazwaproduktu']}</td>
                <td>{$row['Cena']} zł</td>
                <td><button class='order-btn' data-id='{$row['IDproduktu']}'>Zamów</button></td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='3'>Brak produktów w menu.</td></tr>";
}


                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.order-btn');
            buttons.forEach(button => {
                button.addEventListener('click', async () => {
                    const productId = button.dataset.id;
                    const response = await fetch('process_order.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ IDproduktu: productId })
                    });

                    const result = await response.json();
                    alert(result.message);
                });
            });
        });
    </script>
</body>
</html>
