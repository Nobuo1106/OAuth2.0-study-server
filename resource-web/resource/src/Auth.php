<?php
require_once 'User.php';

class Auth {
    private $user;

    // コンストラクタで User クラスのインスタンスを受け取る
    public function __construct(User $user) {
        $this->user = $user;
    }

    // サインイン処理
    public function signIn($email, $password) {
        if ($this->user->signIn($email, $password)) {
            // セッションにユーザー情報を保存 (例としてユーザーのメールアドレス)
            $_SESSION['email'] = $email;
            return true;
        }
        return false;
    }

    // サインアップ処理
    public function signUp($email, $password) {
        // サインアップ処理を呼び出し
        $result = $this->user->signUp($email, $password);
        if ($result === 'User registered successfully') {
            // ユーザーが正常に登録された場合、ログインも自動で行う
            $_SESSION['email'] = $email;
        }
        return $result;
    }

    // サインアウト処理
    public function signOut() {
        session_unset();
        session_destroy();
    }

    // ログインしているかの確認
    public function isLoggedIn() {
        return isset($_SESSION['email']);
    }
}