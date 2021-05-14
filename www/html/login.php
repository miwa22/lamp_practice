<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

// セッションスタート
session_start();
// $_SESSION['user_id']が''でなかった場合
if (is_logined() === true) {
  // ホームページリダイレクト
  redirect_to(HOME_URL);
}
$token = get_csrf_token();
include_once VIEW_PATH . 'login_view.php';
