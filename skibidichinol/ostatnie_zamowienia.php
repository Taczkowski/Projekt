<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Obsługa sortowania
$sort = $_GET['sort'] ?? 'default';
$allowed_sorts = ['nazwa-asc', 'nazwa-desc', 'cena-asc', 'cena-desc', 'status-asc', 'status-desc'];
$sort = in_array($sort, $allowed_sorts) ? $sort : 'default';

// Mapowanie sortowania na zapytanie SQL
$sort_map = [
    'nazwa-asc' => 'p.Nazwaproduktu ASC',
    'nazwa-desc' => 'p.Nazwaproduktu DESC',
    'cena-asc' => 'z.Cena ASC',
    'cena-desc' => 'z.Cena DESC',
    'status-asc' => 'z.Zrealizowano ASC',
    'status-desc' => 'z.Zrealizowano DESC',
    'default' => 'z.IDzamowienia DESC'
];

$order_by = $sort_map[$sort];

$user_id = $_SESSION['user_id'];
$orders = [];

try {
    $stmt = $conn->prepare("
        SELECT z.Cena, p.Nazwaproduktu, 
               CASE WHEN z.Zrealizowano = 1 THEN 'Zrealizowane' ELSE 'W trakcie' END AS Status
        FROM zamowienia z
        INNER JOIN produkty p ON z.IDproduktu = p.IDproduktu
        WHERE z.IDkonta = ?
        ORDER BY $order_by
        LIMIT 15
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    
    $stmt->close();
} catch (Exception $e) {
    $error = "Błąd przy pobieraniu zamówień: " . $e->getMessage();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Historia Zamówień</title>
    <link rel="stylesheet" href="zamowienia.css">
</head>
<body>
    <!-- ... (pozostała część HTML taka sama) ... -->
    
    <div class="content">
        <div class="orders-section"> 
        <button class="back-btn" onclick="window.location.href='main.php'">Powrót do menu</button>
            <h2>Historia Zamówień</h2>
            <!-- W sekcji z zamówieniami -->

            
            <?php if (isset($error)): ?>
                <div class="error-message"><?= $error ?></div>
            <?php elseif (empty($orders)): ?>
                <p class="no-orders">Brak historii zamówień</p>
            <?php else: ?>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th class="sortable" data-sort="nazwa">Produkt 
                                <?= get_sort_arrow('nazwa') ?>
                            </th>
                            <th class="sortable" data-sort="cena">Cena 
                                <?= get_sort_arrow('cena') ?>
                            </th>
                            <th class="sortable" data-sort="status">Status 
                                <?= get_sort_arrow('status') ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['Nazwaproduktu']) ?></td>
                            <td><?= number_format($order['Cena'], 2) ?> zł</td>
                            <td><?= htmlspecialchars($order['Status']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <script>
    // Obsługa kliknięć w nagłówki
    document.querySelectorAll('.sortable').forEach(header => {
        header.addEventListener('click', () => {
            const sortField = header.dataset.sort;
            const currentSort = '<?= $sort ?>';
            let newSort;
            
            if (currentSort.startsWith(sortField)) {
                newSort = currentSort.includes('asc') ? 
                    `${sortField}-desc` : 
                    `${sortField}-asc`;
            } else {
                newSort = `${sortField}-asc`;
            }
            
            window.location.href = `?sort=${newSort}`;
        });
    });
    </script>
</body>
</html>

<?php
function get_sort_arrow($field) {
    $current = $_GET['sort'] ?? '';
    if (strpos($current, $field) === 0) {
        return strpos($current, 'asc') !== false ? '↑' : '↓';
    }
    return '';
}
?>