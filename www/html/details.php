<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

session_start();

if (is_logined() === false) {
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);

$order_id = get_post('order_id');
if (is_admin($user) === TRUE) {
  $details = get_admin_detail($db, $order_id);
} else {
  $details = get_detail($db, $order_id, $user['user_id']);
}

if (is_admin($user) === TRUE) {
  $histories = get_adminhistory_list($db, $order_id);
} else {
  $histories = get_history_list($db, $order_id, $user['user_id']);
}

include_once VIEW_PATH . 'detail_view.php';
