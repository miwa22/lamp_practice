<!DOCTYPE html>
<html lang='ja'>

<head>
    <?php include VIEW_PATH . 'templates/head.php'; ?>
    <title>購入詳細</title>
    <link rel='stylesheet' href='<?php print(STYLESHEET_PATH . 'admin.css'); ?>'>
</head>

<body>
    <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
    <div class='container'>
        <h1>購入詳細</h1>
        <?php include VIEW_PATH . 'templates/messages.php'; ?>
        <table class='table table-bordered'>
            <thead class='thead-light'>
                <tr>
                    <th><button type='button'>注文番号</button</th>
                    <th><button type='button'>購入日時</button></th>
                    <th><button type='button'>合計金額</button></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($histories as $history) { ?>
                    <tr>
                        <td>NO.<?php print(h($history['order-id'])); ?></td>
                        <td><?php print(h($history['created'])); ?></td>
                        <td><?php print($history['total']); ?>円</td>
                        <td>
                            <form method='post' action='detail.php'>
                                <input type='submit' value='購入詳細表示'>
                                <input type='hidden' name='order_id' value='<?php print(h($history['order_id'])); ?>'>
                                <input type='hidden' name='created' value='<?php print(h($history['created'])); ?>'>
                                <input type='hidden' name='total' value='<?php print(h($history['total'])); ?>'>
                                <input type='hidden' name='token' value='<?php print $token ?>'>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <table class='table table-bordered'>
            <thead class='thead-light'>
                <tr>
                    <th><button type='button'>商品名</button></th>
                    <th><button type='button'>価格</button></th>
                    <th><button type='button'>購入数</button></th>
                    <th><button type='button'>小計</button></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($details as $betail) { ?>
                    <tr>
                        <td><?php print(h($detail['name'])); ?></td>
                        <td><?php print(h($detail['price'])); ?>円</td>
                        <td><?php print(h($detail['amount'])); ?>個</td>
                        <td><?php print(h($detail['sutotal'])); ?>円</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>