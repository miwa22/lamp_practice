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
$changes_to = get_post('changes_to');
// $_POST[$name]で値を取得
$token = get_post('token');
if (is_valid_csrf_token($token)) {
  if ($changes_to === 'open') {
    // UPDATE文でstatusの更新処理がなされている
    update_item_status($db, $item_id, ITEM_STATUS_OPEN);
    set_message('ステータスを変更しました。');
  } else if ($changes_to === 'close') {
    // UPDATE文でstatusの更新処理がなされている
    update_item_status($db, $item_id, ITEM_STATUS_CLOSE);
    set_message('ステータスを変更しました。');
  }
} else {
  // エラーメッセージを表示
  set_error('不正なリクエストです。');
}
// adminページへリダイレクト
redirect_to(ADMIN_URL);
