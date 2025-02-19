<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P Diddy Pizza</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="./assets/logo.png" alt="Logo" class="logo">
    </header>

    <div class="center-container">
        <!-- Lewy div z pizzą -->
        <div class="image-box">
            <div class="pizza-container">
                <img src="./assets/BGPIZZA.png" class="pizza-base" alt="Podstawa pizzy">
                <div class="dynamic-ingredients"></div>
            </div>
        </div>
<!-- Zmodyfikowany prawy div z menu -->
<div class="text-box">
    <div class="pizza-menu-container">
        <h2>Menu Pizzy</h2>
        <div class="pizza-menu" id="pizza-menu"></div>
    </div>

    <!-- Custom Pizza UI -->
    <div id="custom-pizza-ui" class="custom-pizza-ui">
<!-- W sekcji custom pizza -->
<div class="custom-header">
    <h3>Stwórz własną pizzę!</h3>
<!-- Zmiana w menu.html -->
<button onclick="exitCustomPizzaMode()">← Wróć</button>
</div>
        <div class="ingredient-selector"></div>
        <button class="confirm-custom" onclick="addCustomPizzaToCart()">Dodaj do koszyka (35zł + 2zł/składnik)</button>
    </div>
</div>
    <!-- Koszyk -->
    <div class="cart" onclick="toggleCart()">
        <img src="./assets/cart.png" alt="Cart Icon" class="cart-icon">
        <span id="cart-count" class="cart-count">0</span>
    </div>

    <!-- Popup koszyka -->
    <div id="cart-popup" class="cart-popup">
        <button id="close-cart" onclick="closeCart()">×</button>
        <h3>Twój koszyk</h3>
        <ul id="cart-items"></ul>
        <div class="cart-total">
            <span>SUMA:</span>
            <span id="cart-total">0 zł</span>
        </div>
        <button id="checkout-btn" onclick="checkout()">Zamów teraz 🍕</button>
    </div>

    <script src="script.js" defer></script>
</div>
</body>
</html>