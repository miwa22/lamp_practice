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
// $_POST['']で値を取得
$password_confirmation = get_post('password_confirmation');
// データベース処理
$db = get_db_connect();
$token = get_post('token');
if (is_valid_csrf_token($token)) {
  try {
    // is_valid_user() === falseの結果が代入
    $result = regist_user($db, $name, $password, $password_confirmation);
    // falseだった場合エラーメッセージを表示
    if ($result === false) {
      set_error('ユーザー登録に失敗しました。');
      // サインアップへリダイレクト
      redirect_to(SIGNUP_URL);
    }
  } catch (PDOException $e) {
    set_error('ユーザー登録に失敗しました。');
    // サインアップへリダイレクト
    redirect_to(SIGNUP_URL);
  }
} else {
  set_error('不正な操作が行われました');
  // サインアップへリダイレクト
  redirect_to(SIGNUP_URL);
}
// $_SESSION['__messages'][]=$message
set_message('ユーザー登録が完了しました。');
// $userにsql SELECT FROM usersテーブル情報を取得
login_as($db, $name, $password);
// ホームページへリダイレクト
redirect_to(HOME_URL);
