<?php
$validUsername = "admin";
$validPassword = "12345";

$username = $_POST['username'];
$password = $_POST['password'];

if ($username === $validUsername && $password === $validPassword) {
    session_start();
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    header("Location: welcome.php");
    exit;
} else {
    header("Location: index.php?error=1");
    exit;
}
?>
