<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form action="login-handler.php" method="post">
        <h2>Logowanie</h2>

        <label for="username_email">Nazwa użytkownika lub e-mail:</label>
        <input type="text" name="username_email" id="username_email" required>

        <label for="password">Hasło:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Zaloguj się</button>
    </form>

    <div>
        <p>Nie masz konta? <a href="register.php">Zarejestruj się tutaj</a></p>
    </div>
</body>
</html>