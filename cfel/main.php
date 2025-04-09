<?php
session_start();
require_once 'db_config.php';
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>P Diddy Pizza - Panel Klienta</title>
    <link rel="stylesheet" href="./stylemain.css">
    <link rel="stylesheet" href="falling-ingredients.css">
</head>
<body>
<div class="snowflakes"></div>
        <header>
            <div class="logo-container">
            <h1 id="header">P.DIDDY PIZZA</h1>
            </div>
    </header>
        </div>

        <div class="content">
            <div class="description-section">
                <div class="action-buttons">
                    <button 
                        class="nav-btn account-btn" 
                        onclick="window.location.href='konto.php'">
                        Zmień dane konta
                    </button>
                    
                    <button 
                        class="nav-btn menu-btn" 
                        onclick="window.location.href='./NewMenuByTaczkowskiTwoPointOu/menu.php'">
                        Zobacz menu
                    </button>
                    
                    <button 
                        class="nav-btn logout-btn" 
                        onclick="window.location.href='logout.php'">
                        Wyloguj
                    </button>
                    <button 
                        class="nav-btn ostatnie-btn" 
                        onclick="window.location.href='ostatnie_zamowienia.php'">
                        Historia zamówień
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="falling-ingredients.js"></script>
    <script src="script.js"></script>
</body>
</html>