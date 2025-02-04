<!DOCTYPE html>
<?php
session_start();

if (isset($_SESSION['success'])) {
    echo '<div class="success-message">'.$_SESSION['success'].'</div>';
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo '<div class="error-message">'.$_SESSION['error'].'</div>';
    unset($_SESSION['error']);
}
?>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona Konta</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="snowflakes"></div>

    <header>
        <div class="logo-container">
            <img src="./assets/Logo.png" alt="Logo" class="logo">
        </div>
    </header>

    <div class="navbar">
        <div class="avatar" id="avatar">
            <img src="./assets/avatar1.png" alt="Avatar">
        </div>
        <button class="nav-btn" data-section="promocje">Kody Promocyjne</button>
        <button class="nav-btn" data-section="konto">Dane Konta</button>
        <button class="nav-btn" data-section="zamowienia">Ostatnie Zamówienia</button>
    </div>

    <main>
        <div id="central-div" class="rounded-box">
            <h2>Witamy na stronie konta</h2>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                echo "<p>Formularz został wysłany!</p>";
            }
            ?>
            <form method="POST" action="update_account.php">
                <label>Imię: <input type="text" name="imie"></label><br>
                <label>Nazwisko: <input type="text" name="nazwisko"></label><br>
                <label>Miejscowość: <input type="text" name="miasto"></label><br>
                <label>Ulica: <input type="text" name="ulica"></label><br>
                <label>Numer telefonu: <input type="text" name="telefon"></label><br>
                <label>Email: <input type="email" name="email"></label><br>
                <button type="submit">Submit</button>
            </form>
            
            
        </div>
    </main>

    <div id="avatar-popup" class="hidden">
        <div class="popup-content">
            <h3>Wybierz avatar</h3>
            <img src="./assets/avatar1.png" alt="Avatar 1" class="avatar-option">
            <img src="./assets/avatar2.png" alt="Avatar 2" class="avatar-option">
            <img src="./assets/avatar3.png" alt="Avatar 3" class="avatar-option">
        </div>
    </div>
    <script src="account.js" defer></script>
</body>
</html>
