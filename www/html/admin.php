<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

//　セッションスタート
session_start();
// $_SESSION['user_id']が''であった場合
if (is_logined() === false) {
  // ログインページリダイレクト
  redirect_to(LOGIN_URL);
}
// データベース処理
$db = get_db_connect();
// $_SESSION['user_id']の値を取得
$user = get_login_user($db);
// $user['type'] === USER_TYPE_ADMINを取得
if (is_admin($user) === false) {
  // ログインページリダイレクト
  redirect_to(LOGIN_URL);
}
$token = get_csrf_token();
// sql SELECT FROM itemsテーブル情報を取得
$items = get_all_items($db);
include_once VIEW_PATH . '/admin_view.php';
