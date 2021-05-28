<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

function get_user_carts($db, $user_id)
{
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE
      carts.user_id = ?
  ";
  return fetch_all_query($db, $sql, [$user_id]);
}

function get_user_cart($db, $user_id, $item_id)
{
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE
      carts.user_id = ?
    AND
      items.item_id = ?
  ";

  return fetch_query($db, $sql, [$user_id, $item_id]);
}

function add_cart($db, $user_id, $item_id)
{
  // get_use_cartはSELECT文でcarts・itemsテーブルを結合された処理
  $cart = get_user_cart($db, $user_id, $item_id);
  if ($cart === false) {

    // insert_cartはINSERT INTO carts(item_id,user_id,amount)の新規追加処理
    return insert_cart($db, $user_id, $item_id);
  }
  // update_cart_amountはUPDATE cartsテーブルはamount・cart_idで更新処理
  return update_cart_amount($db, $cart['cart_id'], $cart['amount'] + 1);
}

function insert_cart($db, $user_id, $item_id, $amount = 1)
{
  $sql = "
    INSERT INTO
      carts(
        item_id,
        user_id,
        amount
      )
    VALUES(?, ?, ?)
  ";

  return execute_query($db, $sql, [$item_id, $user_id, $amount]);
}

function update_cart_amount($db, $cart_id, $amount)
{
  $sql = "
    UPDATE
      carts
    SET
      amount = ?
    WHERE
      cart_id = ?
    LIMIT 1
  ";
  return execute_query($db, $sql, [$amount, $cart_id]);
}


function delete_cart($db, $cart_id)
{
  $sql = "
    DELETE FROM
      carts
    WHERE
      cart_id = ?
    LIMIT 1
  ";

  return execute_query($db, $sql, [$cart_id]);
}

function purchase_carts($db, $carts)
{
  if (validate_cart_purchase($carts) === false) {
    return false;
  }
  // 購入後、カートの中身削除&在庫変動&購入履歴・明細にデータを挿入
  $db->beginTransaction();
  create_history($db, $carts);
  foreach ($carts as $cart) {
    // updata_item_stockはUPDATE文でcartsテーブルでstock・item_idの更新処理
    if (update_item_stock(
      $db,
      $cart['item_id'],
      $cart['stock'] - $cart['amount']
    ) === false) {
      set_error($cart['name'] . 'の購入に失敗しました。');
    }
  }
  // delete_use_cartsはDELETE文でcartsテーブルのuser_id削除処理
  delete_user_carts($db, $carts[0]['user_id']);
  if (has_error() === true) {
    $db->rollback();
    return false;
  } else {
    $db->commit();
    return true;
  }
}

function create_history($db, $carts)
{
  if (insert_history(
    $db,
    $carts[0]['user_id']
  ) === false) {
    set_error('履歴データの作成に失敗しました。');
    return false;
  }
  $order_id = $db->lastInsertId();
  foreach ($carts as $cart) {
    if (insert_detail($db, $order_id, $cart['item_id'], $cart['price'], $cart['amount']) === false) {
      set_error($cart['name'] . '明細データの作成に失敗しました。');
      return false;
    }
  }
  return true;
}
// 購入履歴へINSERT
function insert_history($db, $user_id)
{
  $sql = "
    INSERT INTO
      buy_histories(
        user_id
      )
    VALUES(?)
  ";
  return execute_query($db, $sql, [$user_id]);
}

// 購入明細にINSERT
function insert_detail($db, $order_id, $item_id, $price, $amount)
{
  $sql = "
    INSERT INTO
      buy_detail(
        order_id,
        item_id,
        price,
        amount
      )
    VALUES(?,?,?,?)
  ";
  return execute_query($db, $sql, [$order_id, $item_id, $price, $amount]);
}
// ユーザ毎の購入履歴
function get_history($db, $user_id)
{
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
      buy_histories.order_id
    ORDER BY
      created desc
  ";
  return fetch_all_query($db, $sql, [$user_id]);
}

function get_allhistory($db)
{
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
      buy_histories.order_id
    ORDER BY
      created desc
  ";
  return fetch_all_query($db, $sql);
}

// ユーザ毎の購入明細
function get_detail($db, $order_id)
{
  $sql = "
    SELECT
      buy_detail.price,
      buy_detail.amount,
      items.name
    FROM
      buy_detail
    JOIN
      items
    ON
      buy_detail.item_id = items.item_id
    WHERE
      buy_detail.order_id = ?
   
      //buy_detail.price, buy_detail.amount,items.name
  ";
  return fetch_all_query($db, $sql, [$order_id]);
}
function get_admin_detail($db,$order_id)
{
  $sql = "
    SELECT
      buy_detail.price,
      buy_detail.amount,
      items.name
    FROM
      buy_detail
    JOIN
      items
    ON
      buy_detail.item_id = items.item_id
    
  ";
  return fetch_all_query($db, $sql, [$order_id]);
}

function delete_user_carts($db, $user_id)
{
  $sql = "
    DELETE FROM
      carts
    WHERE
      user_id = ?
  ";

  execute_query($db, $sql, [$user_id]);
}


function sum_carts($carts)
{
  $total_price = 0;
  foreach ($carts as $cart) {
    $total_price += $cart['price'] * $cart['amount'];
  }
  return $total_price;
}

function validate_cart_purchase($carts)
{
  if (count($carts) === 0) {
    set_error('カートに商品が入っていません。');
    return false;
  }
  foreach ($carts as $cart) {
    if (is_open($cart) === false) {
      set_error($cart['name'] . 'は現在購入できません。');
    }
    if ($cart['stock'] - $cart['amount'] < 0) {
      set_error($cart['name'] . 'は在庫が足りません。購入可能数:' . $cart['stock']);
    }
  }
  // has_errorは($_SESSION['__errors']) && count($_SESSION['__errors']) !== 0でなかった場合 
  if (has_error() === true) {
    return false;
  }
  return true;
}

