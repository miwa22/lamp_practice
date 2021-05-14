<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

//　セッションスタート
session_start();
// セッション変数を全て削除
$_SESSION = array();
// セッションクッキーのパラメータを配列で取得
$params = session_get_cookie_params();
// セッションに利用しているクッキーの有効期限を過去に設定することで無効化
setcookie(
  session_name(),
  '',
  time() - 42000,
  $params["path"],
  $params["domain"],
  $params["secure"],
  $params["httponly"]
);
// セッションidを無効化
session_destroy();
// ログインページリダイレクト
redirect_to(LOGIN_URL);
