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
// $SESSION['user_id']の値を取得
$user = get_login_user($db);
// もし$userがuser_type_adminでなかった場合
if (is_admin($user) === false) {
  // ログインページへリダイレクト
  redirect_to(LOGIN_URL);
}
// $_POST['']で値を取得
$item_id = get_post('item_id');
// $_POST['']で値を取得
$token = get_post('token');
if (is_valid_csrf_token($token)) {
  // もしfalseだった場合returnでfalseを返しエラーメッセージを表示しtrueであった場合トランザクション処理
  if (destroy_item($db, $item_id) === true) {
    set_message('商品を削除しました。');
  } else {
    // エラーメッセージを表示
    set_error('商品削除に失敗しました。');
  }
} else {
  // エラーメッセージを表示
  set_error('不正な操作がありました');
}

// adminページへリダイレクト
redirect_to(ADMIN_URL);
