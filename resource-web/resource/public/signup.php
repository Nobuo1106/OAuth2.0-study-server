<?php
require '../config/database.php';
require '../src/User.php';
require '../src/Auth.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$isMobileApp = false;
if ((isset($_SERVER['HTTP_X_CLIENT_TYPE']) && $_SERVER['HTTP_X_CLIENT_TYPE'] === 'app') || 
    (isset($_GET['client_type']) && $_GET['client_type'] === 'app')) {
    $isMobileApp = true;
}

$pdo = new PDO('mysql:host=resource-db;dbname=resource_db', 'resource_user', 'resource_password');
$user = new User($pdo);
$auth = new Auth($user);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($auth->signUp($email, $password)) {
        if ($isMobileApp) {
            header('Location: close://webview'); // iOSクライアント用のリダイレクト
        } else {
            $_SESSION['email'] = $email;
            header('Location: main.php'); // Webクライアント用のリダイレクト
        }
        exit;
    } else {
        echo "ユーザー登録に失敗しました。";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ユーザー登録</title>
</head>
<body>
    <h1>ユーザー登録</h1>
    <form method="POST" action="signup.php">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">登録</button>
    </form>
    <p>もう既にアカウントを作成済みですか？<a href="signin.php">ログイン</a></p>
</body>
</html>