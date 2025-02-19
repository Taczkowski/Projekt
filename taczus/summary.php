<?php
session_start();
require_once 'db_config.php';

// Pobierz zawartość koszyka z sesji
$cart = $_SESSION['cart'] ?? [];
$total = 0;

foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
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
            
            <?php if(empty($cart)): ?>
                <p class="empty-cart">Koszyk jest pusty</p>
            <?php else: ?>
                <div class="cart-items">
                    <?php foreach($cart as $id => $product): ?>
                    <div class="cart-item">
                        <div class="item-info">
                            <span class="item-name"><?= htmlspecialchars($product['name']) ?></span>
                            <span class="item-price"><?= number_format($product['price'], 2) ?> zł</span>
                        </div>
                        <div class="item-quantity">
                            <span>Ilość: <?= $product['quantity'] ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Prawa kolumna - Formularz -->
        <div class="order-section">
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
                    <input type="text" name="fullname" required>
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
                    <input type="email" name="email">
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
            </form>
        </div>
    </div>
    <script src="falling-ingredients.js"></script>
    <script src="script.js"></script>
</body>
</html>