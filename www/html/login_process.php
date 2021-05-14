<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

// セッションスタート
session_start();
// $_SESSION['user_id']が''でなかった場合
if (is_logined() === true) {
  // ホームページへリダイレクト
  redirect_to(HOME_URL);
}
// $_POST['']で値を取得
$name = get_post('name');
// $_POST['']で値を取得
$password = get_post('password');
// データベース処理
$db = get_db_connect();

$token = get_post('token');
if (is_valid_csrf_token($token)) {
  // $userにsql SELECT FROM usersテーブル情報を取得
  $user = login_as($db, $name, $password);  
  // false だった場合エラーメッセージを表示
  if ($user === false) {
    set_error('ログインに失敗しました。');
    // ログインページリダイレクト
    redirect_to(LOGIN_URL);
  }
// エラーがなかった場合ログイン処理
  set_message('ログインしました。');
  if ($user['type'] === USER_TYPE_ADMIN) {
    // adminページへリダイレクト
    redirect_to(ADMIN_URL);
  } else {
    // ログインページリダイレクト
    redirect_to(LOGIN_URL);
  }
} else {
  set_error('不正な操作が行われました');
  // ログインページリダイレクト
  redirect_to(LOGIN_URL);
}
// ホームページへリダイレクト
redirect_to(HOME_URL);
