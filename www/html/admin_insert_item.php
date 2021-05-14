<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

// セッションスタート
session_start();
// $SESSION['user_id']が''であった場合
if (is_logined() === false) {
  // ログインページへリダイレクト
  redirect_to(LOGIN_URL);
}
// データベース処理
$db = get_db_connect();
// $SESSION['use-id']の値を取得
$user = get_login_user($db);
// $user_typeがadminでなかった場合(false)
if (is_admin($user) === false) {
  // ログインページへリダイレクト
  redirect_to(LOGIN_URL);
}
// $_POST['']で値を取得
$name = get_post('name');
// $_POST['']で値を取得
$price = get_post('price');
// $_POST['']で値を取得
$status = get_post('status');
// $_POST['']で値を取得
$stock = get_post('stock');
// $_POST['']で値を取得
$token = get_post('token');
// $_FILE['']で値を取得
$image = get_file('image');

if (is_valid_csrf_token($token)) {
  // もしfalseだった場合returnでfalseを返しエラーメッセージを表示しfalseでなければトランザクション処理
  if (regist_item($db, $name, $price, $stock, $status, $image)) {
    set_message('商品を登録しました。');
  } else {
    // エラーメッセージを表示
    set_error('商品の登録に失敗しました。');
  }
} else {
  // エラーメッセージを表示
  set_error('不正な操作が行われました');
}
// adminページへリダイレクト
redirect_to(ADMIN_URL);
