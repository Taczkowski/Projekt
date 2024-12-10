<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $conn = new mysqli("localhost", "root", "", "pdiddypizza");

    if ($conn->connect_error) {
        die("Połączenie z bazą danych nie powiodło się: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM konta WHERE Login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Passwd'])) {
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['username'] = $user['Login'];

            header("Location: order.php");
            exit();
        } else {
            $error = "Błędne hasło!";
        }
    } else {
        $error = "Błędny login!";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylelogin.css">
    <title>Logowanie</title>
</head>
<body>
    <h1>Logowanie</h1>
    <form action="login.php" method="POST">
        <label for="username">Login:</label>
        <input type="text" name="username" id="username" required>
        
        <label for="password">Hasło:</label>
        <input type="password" name="password" id="password" required>
        
        <button type="submit">Zaloguj</button>
    </form>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
</body>
</html>
