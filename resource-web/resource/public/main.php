<?php
require '../config/database.php';
require '../src/Auth.php';

session_start();

// ユーザーがログインしているか確認
// if (!isset($_SESSION['email'])) {
//     header('Location: index.php');
//     exit;
// }

$pdo = new PDO('mysql:host=resource-db;dbname=resource_db', 'resource_user', 'resource_password');

// ログイン出来ていない
$auth = new Auth(new User($pdo));
if (!$auth->isLoggedIn()) {
    header('Location: index.php');
    exit;
}

// ログアウト処理
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $auth->signOut();
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>メイン画面</title>
</head>
<body>
    <h1>メイン画面</h1>
    <p>
        <a href="main.php?action=logout">ログアウト</a>
    </p>
</body>
</html>