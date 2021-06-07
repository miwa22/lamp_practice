<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

//セッションスタート
session_start();
// $_SESSION['user_id']が''であった場合
if (is_logined() === false) {
  // ログインページリダイレクト
  redirect_to(LOGIN_URL);
}
// トークン生成
$token = get_csrf_token();
// データベース処理
$db = get_db_connect();
// $_SESSION['user_id']の値を取得
$user = get_login_user($db);
// sql SELECT FROM itemsテーブル情報を取得
$items = get_open_items($db);
//$items = change_htmlsp_array($data);

$ranking = get_open_ranking($db);
//$ranking = change_htmlsp_array($data_ranking);

include_once VIEW_PATH . 'index_view.php';
