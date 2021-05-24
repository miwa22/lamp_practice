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
  //ログインページにリダイレクト
  redirect_to(LOGIN_URL);
}
// データベース処理
$db = get_db_connect();
// $_SESSION['user_id']の値を取得
$user = get_login_user($db);
// $_POST['']で渡された値を取得
$token = get_post('token');
if (is_valid_csrf_token($token)) {
  // sql SELECT*FROM carts・itemsテーブルの結合がされている
  $carts = get_user_carts($db, $user['user_id']);
  // カート商品が0だった場合エラーメッセージ表示
  if (purchase_carts($db, $carts) === false) {
    
    set_error('商品が購入できませんでした。');
    // カートURLにリダイレクト
    redirect_to(CART_URL);
  }
} else {
  set_error('不正な操作が行われました');
  redirect_to(CART_URL);
}
// 値段*数量の合計値
$total_price = sum_carts($carts);

include_once '../view/finish_view.php';
