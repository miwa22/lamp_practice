<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

//　セッションスタート
session_start();
// $_SESSION['user_id']が''であった場合
if (is_logined() === false) {
  // ログインページへリダイレクト
  redirect_to(LOGIN_URL);
}
// データベース処理
$db = get_db_connect();
// $_SESSION['user_id']で値を取得
$user = get_login_user($db);
$token = get_post('token');
// $_POST['cart_id']の値を取得
$cart_id = get_post('cart_id');
if (is_valid_csrf_token($token)) {
  // sql DELETE FROM cartsテーブル情報取得
  if (delete_cart($db, $cart_id)) {
    // set_message()でメッセージ入力
    set_message('カートを削除しました。');
  } else {
    // エラーメッセージを表示
    set_error('カートの削除に失敗しました。');
  }
} else {
  // エラーメッセージを表示
  set_error('不正な操作が行われました');
}
// カートページへリダイレクト
redirect_to(CART_URL);
