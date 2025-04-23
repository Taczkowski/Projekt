<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Obsługa sortowania
$sort = $_GET['sort'] ?? 'default';
$allowed_sorts = ['data-asc', 'data-desc', 'cena-asc', 'cena-desc', 'status-asc', 'status-desc'];
$sort = in_array($sort, $allowed_sorts) ? $sort : 'default';

// Mapowanie sortowania na zapytanie SQL
$sort_map = [
    'data-asc' => 'z.data_zamowienia ASC',
    'data-desc' => 'z.data_zamowienia DESC',
    'cena-asc' => 'zs.cena ASC',
    'cena-desc' => 'zs.cena DESC',
    'status-asc' => 'z.status ASC',
    'status-desc' => 'z.status DESC',
    'default' => 'z.data_zamowienia DESC'
];

$order_by = $sort_map[$sort];
$user_id = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("
        SELECT 
            z.id_zamowienia,
            z.data_zamowienia,
            z.status,
            zs.nazwa_pizzy,
            zs.skladniki,
            zs.cena,
            zs.ilosc
        FROM zamowienia z
        JOIN zamowienia_szczegoly zs ON z.id_zamowienia = zs.id_zamowienia
        WHERE z.id_uzytkownika = ?
        ORDER BY $order_by
        LIMIT 15
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = $result->fetch_all(MYSQLI_ASSOC);
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia Zamówień</title>
    <link rel="stylesheet" href="zamowienia.css">
</head>
<body>
    <div class="content">
        <div class="orders-section">
            <button class="back-btn" onclick="window.location.href='main.php'">← Powrót do menu</button>
            <h2>Historia Zamówień</h2>
            
            <?php if (isset($error)): ?>
                <div class="error-message"><?= $error ?></div>
            <?php elseif (empty($orders)): ?>
                <p class="no-orders">Brak zamówień</p>
            <?php else: ?>
                <div class="orders-table-container">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th class="sortable" data-sort="data">Data <?= get_sort_arrow('data') ?></th>
                                <th>Pizza</th>
                                <th>Składniki</th>
                                <th class="sortable" data-sort="cena">Cena <?= get_sort_arrow('cena') ?></th>
                                <th>Ilość</th>
                                <th class="sortable" data-sort="status">Status <?= get_sort_arrow('status') ?></th>
                            </tr>
                        </thead>
                        <tbody>
    <?php foreach ($orders as $order): ?>
    <tr>
        <td data-label="Data"><?= date('d.m.y H:i', strtotime($order['data_zamowienia'])) ?></td>
        <td data-label="Pizza"><?= htmlspecialchars($order['nazwa_pizzy']) ?></td>
        <td data-label="Składniki">
            <?php 
                $skladniki = json_decode($order['skladniki'], true);
                echo implode(', ', $skladniki); 
            ?>
        </td>
        <td data-label="Cena"><?= number_format($order['cena'], 2) ?> zł</td>
        <td data-label="Ilość"><?= $order['ilosc'] ?></td>
        <td data-label="Status"><?= ucfirst($order['status']) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>

                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    document.querySelectorAll('.sortable').forEach(header => {
        header.addEventListener('click', () => {
            const sortField = header.dataset.sort;
            const currentSort = '<?= $sort ?>';
            let newSort;
            
            if (currentSort.startsWith(sortField)) {
                newSort = currentSort.includes('asc') ? `${sortField}-desc` : `${sortField}-asc`;
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