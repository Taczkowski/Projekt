<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Witamy</title>
</head>
<body>
    <h1>Witamy, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>Jesteś zalogowany.</p>
    <a href="logout.php">Wyloguj się</a>
</body>
</html>