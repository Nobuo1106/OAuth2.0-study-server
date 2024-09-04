<?php
require '../config/database.php';
require '../src/User.php';
require '../src/Auth.php';

$pdo = new PDO('mysql:host=resource-db;dbname=resource_db', 'resource_user', 'resource_password');
$user = new User($pdo);
$auth = new Auth($user);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($auth->signIn($email, $password)) {
        header('Location: main.php');
        exit;
    } else {
        echo "Signin failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>OAuth2.0勉強</title>
</head>
<body>
    <h1>ログイン</h1>
    <form method="POST" action="index.php">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">ログイン</button>
    </form>
    <p>アカウントの作成がまだお済みでないですか？ <a href="signup.php">新規登録</a></p>
</body>
</html>