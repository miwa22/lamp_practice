<?php
require_once MODEL_PATH. 'functions.php';
require_once MODEL_PATH. 'db.php';

// ユーザ毎の購入履歴
/*function get_history($db, $user_id){
    $sql = "
      SELECT
        buy_histories.order_id,
        buy_histories.created,
        SUM(buy_detail.price * buy_detail.amount) AS total
      FROM
        buy_histories
      JOIN
        buy_detail
      ON
        buy_histories.order_id = buy_detail.order_id
      WHERE
        user_id = ?
      GROUP BY
        order_id
      ORDER BY
        created desc
    ";
    return fetch_all_query($db, $sql, [$user_id]);
}
function get_allhistory($db){
  $sql = "
      SELECT
        buy_histories.order_id,
        buy_histories.created,
        SUM(buy_detail.price * buy_detail.amount) AS total
      FROM
        buy_histories
      JOIN
        buy_detail
      ON
        buy_histories.order_id = buy_detail.order_id
      GROUP BY
        order_id
      ORDER BY
        order_id desc
    ";
    return fetch_all_query($db, $sql);
}*/
