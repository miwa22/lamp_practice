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
  // ログインページへリダイレクト
  redirect_to(LOGIN_URL);
}
// データベース処理
$db = get_db_connect();
// $_SESSION['user_id']の値を取得
$user = get_login_user($db);
$token = get_post('token');
// $_POST['item_id']で値を取得
$item_id = get_post('item_id');
if (is_valid_csrf_token($token)) {
  // もし$cart === falseでなかった場合カート数量の更新、falseだった場合商品の新規追加
  if (add_cart($db, $user['user_id'], $item_id)) {
    // set_message()でメッセージ追加
    set_message('カートに商品を追加しました。');
  } else {
    set_error('カートの更新に失敗しました。');
  }
} else {
  set_error('不正な操作が行われました');
}
// ホームページへリダイレクト
redirect_to(HOME_URL);
