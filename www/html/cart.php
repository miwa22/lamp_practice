<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

//セッションスタート
session_start();
// $_SESSION['user_id']が''であった場合
if (is_logined() === false) {
  //　ログインページへリダイレクト
  redirect_to(LOGIN_URL);
}
// データベースの処理
$db = get_db_connect();
// $_SESSION['user_id']の値を取得
$user = get_login_user($db);
// sql SELECT*FROM carts・itemsテーブルの結合がされている
$carts = get_user_carts($db, $user['user_id']);

$token = get_csrf_token();
// 値段*数量の合計値
$total_price = sum_carts($carts);

include_once VIEW_PATH . 'cart_view.php';
