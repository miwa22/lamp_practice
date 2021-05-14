<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

// セッションスタート
session_start();
// $_SESSION['user_id']が''であった場合
if (is_logined() === false) {
  // ログインページリダイレクト
  redirect_to(LOGIN_URL);
}
// データベース処理
$db = get_db_connect();
// $_SESSION['user_id']で値を取得
$user = get_login_user($db);
// $_POST['cart_id']で値を取得
$cart_id = get_post('cart_id');
// $_POST['amount']で値を取得
$amount = get_post('amount');
$token = get_post('token');
if (is_valid_csrf_token($token)) {
  // UPDATE FROM cartsテーブルで数量更新情報取得
  if (update_cart_amount($db, $cart_id, $amount)) {
    // set_message()メッセージ追加
    set_message('購入数を更新しました。');
  } else {
    // エラーメッセージを表示
    set_error('購入数の更新に失敗しました。');
  }
} else {
  // エラーメッセージを表示
  set_error('不正な操作が行われました。');
}
// カートページへリダイレクト
redirect_to(CART_URL);
