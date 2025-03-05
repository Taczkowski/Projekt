<?php
session_start();

// Odbierz dane z koszyka z URL
if (isset($_GET['cart'])) {
    $cart = json_decode(urldecode($_GET['cart']), true);

    // Grupowanie pizz według nazwy i sumowanie ilości
    $groupedCart = [];
    foreach ($cart as $item) {
        $name = $item['name'];
        $quantity = $item['quantity'] ?? 1; // Ustaw domyślną ilość na 1, jeśli klucz nie istnieje

        if (isset($groupedCart[$name])) {
            $groupedCart[$name]['quantity'] += $quantity;
        } else {
            $groupedCart[$name] = $item;
            $groupedCart[$name]['quantity'] = $quantity; // Upewnij się, że ilość jest ustawiona
        }
    }
    $_SESSION['cart'] = $groupedCart;
} else {
    $groupedCart = $_SESSION['cart'] ?? [];
}

// Oblicz całkowitą kwotę zamówienia
$total = 0;
foreach ($groupedCart as $item) {
    $quantity = $item['quantity'] ?? 1; // Ustaw domyślną ilość na 1, jeśli klucz nie istnieje
    $total += $item['price'] * $quantity;
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
                                <span>Ilość: <?= $item['quantity'] ?? 1 ?></span> <!-- Ustaw domyślną ilość na 1 -->
                            </div>
                            <button class="btn-del" onclick="removeFromCart('<?= htmlspecialchars($name) ?>')">Usuń jedną</button>
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
                <a href="menu.php" class="btn-back">← Wróć do menu</a>
            </form>
        </div>
    </div>

    <script src="falling-ingredients.js"></script>
    <script src="script.js"></script>
    <script src="scriptmenu.js"></script>
    <script>
    // Funkcja do usuwania jednej pizzy z koszyka
    function removeFromCart(name) {
        // Pobierz koszyk z localStorage
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Znajdź indeks produktu o podanej nazwie
        const index = cart.findIndex(item => item.name === name);

        if (index !== -1) {
            // Zmniejsz ilość o 1
            cart[index].quantity -= 1;

            // Jeśli ilość spadnie do 0, usuń produkt z koszyka
            if (cart[index].quantity <= 0) {
                cart.splice(index, 1);
            }

            // Zapisz zaktualizowany koszyk z powrotem do localStorage
            localStorage.setItem('cart', JSON.stringify(cart));

            // Natychmiast zaktualizuj wyświetlanie koszyka na stronie
            updateCartDisplay();
        }
    }

    // Funkcja do aktualizacji wyświetlania koszyka
    function updateCartDisplay() {
        const cartItemsContainer = document.querySelector('.cart-items');
        cartItemsContainer.innerHTML = '';
        let total = 0;

        // Pobierz koszyk z localStorage
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Grupowanie pizz według nazwy i sumowanie ilości
        let groupedCart = {};
        cart.forEach(item => {
            const name = item.name;
            const quantity = item.quantity || 1; // Ustaw domyślną ilość na 1, jeśli klucz nie istnieje

            if (groupedCart[name]) {
                groupedCart[name].quantity += quantity;
            } else {
                groupedCart[name] = { ...item, quantity: quantity };
            }
        });

        // Wyświetl każdą grupę produktów w koszyku
        Object.keys(groupedCart).forEach(name => {
            const item = groupedCart[name];
            const itemElement = document.createElement('div');
            itemElement.classList.add('cart-item');
            itemElement.id = `item-${name}`;
            itemElement.innerHTML = `
                <div class="item-info">
                    <span class="item-name">${name}</span>
                    <span class="item-price">${item.price.toFixed(2)} zł</span>
                </div>
                <div class="item-quantity">
                    <span>Ilość: ${item.quantity}</span>
                </div>
                <button class="btn-del" onclick="removeFromCart('${name}')">Usuń jedną</button>
            `;
            cartItemsContainer.appendChild(itemElement);
            total += item.price * item.quantity;
        });

        // Zaktualizuj całkowitą kwotę
        document.querySelector('.total-price').textContent = `${total.toFixed(2)} zł`;
    }

    // Wywołaj funkcję aktualizującą koszyk przy załadowaniu strony
    document.addEventListener('DOMContentLoaded', updateCartDisplay);
</script>
</body>
</html>