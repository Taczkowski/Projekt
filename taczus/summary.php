<?php
session_start();

if (isset($_GET['cart'])) {
    $cart = json_decode(urldecode($_GET['cart']), true);

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

$total = 0;
foreach ($groupedCart as $item) {
    $quantity = $item['quantity'] ?? 1;
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
    <style>
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-right: 15px;
        }
        .quantity-btn {
            background: #ff5722;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .quantity-value {
            min-width: 20px;
            text-align: center;
            font-weight: bold;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .item-info {
            flex: 1;
        }
        .item-actions {
            display: flex;
            align-items: center;
        }
        .btn-del {
            background: #ff3333;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="snowflakes"></div>
    
    <div class="order-container">
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
                            <div class="item-actions">
                                <div class="quantity-controls">
                                    <button class="quantity-btn" onclick="updateQuantity('<?= htmlspecialchars($name) ?>', -1)">-</button>
                                    <span class="quantity-value"><?= $item['quantity'] ?? 1 ?></span>
                                    <button class="quantity-btn" onclick="updateQuantity('<?= htmlspecialchars($name) ?>', 1)">+</button>
                                </div>
                                <button class="btn-del" onclick="removeItem('<?= htmlspecialchars($name) ?>')">Usuń</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="order-section">
            <div class="order-summary">
                <h3>Podsumowanie</h3>
                <div class="summary-row">
                    <span>Suma:</span>
                    <span class="total-price"><?= number_format($total, 2) ?> zł</span>
                </div>
            </div>

            <form class="order-form" action="process_order.php" method="POST" id="orderForm">
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
    <script>
    function updateQuantity(name, change) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const index = cart.findIndex(item => item.name === name);
        
        if (index !== -1) {
            cart[index].quantity = (cart[index].quantity || 1) + change;
            
            if (cart[index].quantity <= 0) {
                cart.splice(index, 1);
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartDisplay();
        }
    }

    function removeItem(name) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart = cart.filter(item => item.name !== name);
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartDisplay();
    }

    function updateCartDisplay() {
        const cartItemsContainer = document.querySelector('.cart-items');
        const totalPriceElement = document.querySelector('.total-price');
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let total = 0;

        let groupedCart = {};
        cart.forEach(item => {
            const name = item.name;
            const quantity = item.quantity || 1;

            if (groupedCart[name]) {
                groupedCart[name].quantity += quantity;
            } else {
                groupedCart[name] = { ...item, quantity: quantity };
            }
        });

        cartItemsContainer.innerHTML = '';
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
                <div class="item-actions">
                    <div class="quantity-controls">
                        <button class="quantity-btn" onclick="updateQuantity('${name}', -1)">-</button>
                        <span class="quantity-value">${item.quantity}</span>
                        <button class="quantity-btn" onclick="updateQuantity('${name}', 1)">+</button>
                    </div>
                    <button class="btn-del" onclick="removeItem('${name}')">Usuń</button>
                </div>
            `;
            cartItemsContainer.appendChild(itemElement);
            total += item.price * item.quantity;
        });

        totalPriceElement.textContent = `${total.toFixed(2)} zł`;

        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<p class="empty-cart">Koszyk jest pusty</p>';
        }
    }

    document.addEventListener('DOMContentLoaded', updateCartDisplay);

    document.getElementById('orderForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        formData.append('cart', JSON.stringify(cart));
        
        fetch('process_order.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                localStorage.removeItem('cart');
                window.location.href = 'main.php?order_success=1';
            } else {
                alert('Wystąpił błąd: ' + (data.message || 'Nie udało się złożyć zamówienia'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Wystąpił błąd podczas składania zamówienia');
        });
    });
    </script>
</body>
</html>