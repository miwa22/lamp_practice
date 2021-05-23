<?php
require_once '../conf/const.php';
require_once MODEL_PATH. 'functions.php';
require_once MODEL_PATH. 'users.php';
require_once MODEL_PATH. 'items.php';
require_once MODEL_PATH. 'carts.php';
require_once MODEL_PATH. 'historyeis.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);
$histories = get_history($db, $user['user_id']);

$order_id = get_post('order_id');

include_once VIEW_PATH. 'history_view.php';