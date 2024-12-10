<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form action="register-handler.php" method="post">
        <h2>Rejestracja</h2>

        <label for="username">Nazwa użytkownika:</label>
        <input type="text" name="username" id="username" required>

        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Hasło:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Zarejestruj się</button>
    </form>
</body>
</html>