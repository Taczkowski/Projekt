<?php
session_start();

// Sprawdź czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Odbierz dane z koszyka z URL lub sesji
if (isset($_GET['cart'])) {
    $cart = json_decode(urldecode($_GET['cart']), true);
    
    // Grupowanie pizz według nazwy i sumowanie ilości
    $groupedCart = [];
    foreach ($cart as $item) {
        $name = $item['name'];
        $quantity = $item['quantity'] ?? 1;

        if (isset($groupedCart[$name])) {
            $groupedCart[$name]['quantity'] += $quantity;
        } else {
            $groupedCart[$name] = $item;
            $groupedCart[$name]['quantity'] = $quantity;
        }
    }
    $_SESSION['cart'] = $groupedCart;
} else {
    $groupedCart = $_SESSION['cart'] ?? [];
}

// Oblicz całkowitą kwotę zamówienia
$total = 0;
foreach ($groupedCart as $item) {
    $quantity = $item['quantity'] ?? 1;
    $total += $item['price'] * $quantity;
}

// Obsługa błędów
$error = $_GET['error'] ?? null;
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>P Diddy Pizza - Finalizacja zamówienia</title>
    <link rel="stylesheet" href="summary.css">
    <link rel="stylesheet" href="falling-ingredients.css">
</head>
<body>
    <div class="snowflakes"></div>
    
    <div class="order-container">
        <!-- Lewa kolumna - Koszyk -->
        <div class="cart-section">
            <h2>Twój koszyk</h2>
            
            <?php if(empty($groupedCart)): ?>
                <p class="empty-cart">Koszyk jest pusty</p>
            <?php else: ?>
                <div class="cart-items">
                    <?php foreach($groupedCart as $name => $item): ?>
                        <div class="cart-item" id="item-<?= htmlspecialchars($name) ?>">
                            <div class="item-info">
                                <span class="item-name"><?= htmlspecialchars($name) ?></span>
                                <span class="item-price"><?= number_format($item['price'], 2) ?> zł</span>
                            </div>
                            <div class="item-quantity">
                                <span>Ilość: <?= $item['quantity'] ?? 1 ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Prawa kolumna - Formularz -->
        <div class="order-section">
            <?php if($error): ?>
                <div class="error-message">
                    <?php if($error == 1): ?>
                        Wystąpił błąd podczas składania zamówienia. Spróbuj ponownie.
                    <?php elseif($error == 2): ?>
                        Koszyk jest pusty lub nie jesteś zalogowany.
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="order-summary">
                <h3>Podsumowanie</h3>
                <div class="summary-row">
                    <span>Suma:</span>
                    <span class="total-price"><?= number_format($total, 2) ?> zł</span>
                </div>
            </div>

            <form class="order-form" action="process_order.php" method="POST">
                <div class="form-group">
                    <label>Imię i nazwisko *</label>
                    <input type="text" name="fullname" required value="<?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '' ?>">
                </div>
                
                <div class="form-group">
                    <label>Adres dostawy *</label>
                    <textarea name="address" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label>Miasto *</label>
                    <input type="text" name="city" required>
                </div>

                <div class="form-group">
                    <label>Numer telefonu *</label>
                    <input type="tel" name="phone" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '' ?>">
                </div>

                <div class="payment-methods">
                    <h3>Metoda płatności</h3>
                    <label class="payment-option">
                        <input type="radio" name="payment" value="cash" checked>
                        <span class="payment-icon">💵</span>
                        <span>Gotówka przy odbiorze</span>
                    </label>
                    
                    <label class="payment-option">
                        <input type="radio" name="payment" value="card">
                        <span class="payment-icon">💳</span>
                        <span>Płatność kartą</span>
                    </label>
                </div>

                <button type="submit" class="btn-submit">Złóż zamówienie</button>
                <a href="main.php" class="btn-back">← Wróć do menu</a>
            </form>
        </div>
    </div>

    <script src="falling-ingredients.js"></script>
    <script>
    // Funkcja do usuwania jednej pizzy z koszyka
    function removeFromCart(name) {
        fetch('remove_from_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({name: name})
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            }
        });
    }

    // Aktualizuj wyświetlanie koszyka przy załadowaniu strony
    document.addEventListener('DOMContentLoaded', function() {
        // Możesz dodać tutaj dodatkowe inicjalizacje jeśli potrzebne
    });
    </script>
</body>
</html>