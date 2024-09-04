<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // サインアップ処理
    public function signUp($email, $password) {
        // パスワードをハッシュ化
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // ユーザーの重複チェック
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            return false;
        }

        // 新しいユーザーを挿入
        $stmt = $this->pdo->prepare('INSERT INTO users (email, password, created_at, updated_at) VALUES (:email, :password, NOW(), NOW())');
        if ($stmt->execute(['email' => $email, 'password' => $hashedPassword])) {
            return true;
        }
        return false;
    }

    // サインイン処理
    public function signIn($email, $password) {
        // ユーザーを検索
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        // パスワードの照合
        if ($user && password_verify($password, $user['password'])) {
            return true;
        }
        return false;
    }
}