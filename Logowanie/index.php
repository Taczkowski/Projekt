<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Logowanie</title>
</head>
<body>
    <div class="login-container">
        <h2>Logowanie</h2>
        <?php
        if (isset($_GET['error'])) {
            echo '<div class="error">Nieprawidłowa nazwa użytkownika lub hasło.</div>';
        }
        ?>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Nazwa użytkownika" required>
            <input type="password" name="password" placeholder="Hasło" required>
            <button type="submit">Zaloguj</button>
        </form>
    </div>
</body>
</html>
