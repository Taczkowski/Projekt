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
</head>
<body>
    <div class="snowflakes"></div>
    
    <div class="account-container">
        <div class="sidebar">
            <div class="logo-container">
                <img src="./assets/Logo.png" alt="Logo" class="logo">
                <img src="./assets/pizza.png" alt="Pizza" class="pizza">
            </div>
        </div>

        <div class="content">
            <div class="description-section">
                <h2>Witamy w P Diddy Pizza!</h2>
                <p class="pizzeria-description">
                    Od 1998 roku dostarczamy prawdziwą włoską pasję w każdym kęsie! 
                    Nasze pizza powstają wyłącznie z najświeższych składników, 
                    a secretne receptury przekazywane są z pokolenia na pokolenie. 
                    Nie wierzysz? Sprawdź nasze menu!
                </p>
                
                <div class="action-buttons">
                    <button 
                        class="nav-btn account-btn" 
                        onclick="window.location.href='konto.php'">
                        Zmień dane konta
                    </button>
                    
                    <button 
                        class="nav-btn menu-btn" 
                        onclick="window.location.href='menu.php'">
                        Zobacz menu
                    </button>
                    
                    <button 
                        class="nav-btn logout-btn" 
                        onclick="window.location.href='logout.php'">
                        Wyloguj
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>