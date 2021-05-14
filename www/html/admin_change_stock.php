<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

// セッションスタート
session_start();
// $_SESSION['user_id']が''であった場合
if (is_logined() === false) {
  // ログインページへリダイレクト
  redirect_to(LOGIN_URL);
}
// データベース処理
$db = get_db_connect();
// $_SESSION['user_id']の値を取得
$user = get_login_user($db);
// もし$userがuser_type_adminでなかった場合(false)
if (is_admin($user) === false) {
  // ログインページへリダイレクト
  redirect_to(LOGIN_URL);
}
// $_POST[$name]で値を取得
$item_id = get_post('item_id');
// $_POST[$name]で値を取得
$stock = get_post('stock');
// $_POST[$name]で値を取得
$token = get_post('token');
if (is_valid_csrf_token($token)) {
  // sql UPDATE 文の処理がなされている
  if (update_item_stock($db, $item_id, $stock)) {
    set_message('在庫数を変更しました。');
  } else {
    // エラーメッセージを表示
    set_error('在庫数の変更に失敗しました。');
  }
} else {
  // エラーメッセージを表示
  set_error('不正な操作が行われました。');
}
// adminページへリダイレクト
redirect_to(ADMIN_URL);
