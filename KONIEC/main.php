<?php
session_start();
require_once 'db_config.php';
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Przełącznik Motywów</title>
    <link rel="stylesheet" href="stylemain.css">
    <link rel="stylesheet" href="falling-ingredients.css">
    <link rel="stylesheet" href="./transition.css">
    <script src="./transition.js" defer></script>
    <script src="./falling-ingredients.js" defer></script>
</head>
<body>
<div class="initial-animation-container">
        <img id="left" src="./assets/left.png" alt="">
        <img id="right" src="./assets/right.png" alt="">
        <img id="leftbottom" src="./assets/leftbottom.png" alt="">
        <img id="lefttop" src="./assets/lefttop.png" alt="">
        <img id="rightbottom" src="./assets/rightbottom.png" alt="">
        <img id="righttop" src="./assets/righttop.png" alt="">
      </div>
<header>
    <div class="logo-container">
    <h1 id="header">P.DIDDY PIZZA</h1>
    </div>
<div class="navbar">
    <img src="assets/HSPIZZA.png" alt="Pizza" class="pizza-img">
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
        <button 
            class="nav-btn ostatnie-btn" 
            onclick="window.location.href='ostatnie_zamowienia.php'">
            Historia zamówień
        </button>
    </div>
</div>
</header>
<main>
    <div><h2>OGNISTA PROMOCJA W OGNISTE PIĄTKI !!!!!!</h2></div>
    <div><img src="assets/PROMOCJA.png"></div>
</main>
    <body data-theme="day">
        <div class="theme-switcher" id="themeSwitcher">
            <div class="theme-switcher-icon" id="themeSwitcherIcon">
                <img src="day.png" alt="Current Theme" id="themeIcon">
            </div>
            <div class="switcher-container collapsed" id="switcherContainer">
                <div class="theme-switcher-toggle" id="themeSwitcherToggle">
                    <div class="slider" id="slider">
                        <img src="day.png" alt="Day" class="theme-icon">
                    </div>
                </div>
            </div>
        </div>
        <script src="scriptmain.js"></script>
    </body>
<?php

if (isset($_GET['order_success'])) {
    echo '<div class="alert alert-success">Zamówienie zostało złożone pomyślnie!</div>';
}
?>
</html>