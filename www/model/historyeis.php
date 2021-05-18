<?php
// ユーザ毎の購入明細
function get_detail($db, $order_id){
    $sql = "
      SELECT
        buy_detail.price,
        buy_detail.amount,
        SUM(buy_detail.price * buy_detail.amount) AS subtotal,
        items.name
      FROM
        buy_detail
      JOIN
        items
      ON
        buy_detail.item_id = items.item_id
      WHERE
        order_id = ?
      GROUP BY
        buy_detail.price, buy_detail.amount,items.name
    ";
    return fetch_all_query($db, $sql, [$order_id]);
}