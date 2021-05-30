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
                    <th>注文番号</th>
                    <th>購入日時</th>
                    <th>合計金額</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($histories as $history) { ?>
                    <tr>
                        <td>NO.<?php print(h($history['order_id'])); ?></td>
                        <td><?php print(h($history['created'])); ?></td>
                        <td><?php print($history['total']); ?>円</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <table class='table table-bordered'>
            <thead class='thead-light'>
                <tr>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>購入数</th>
                    <th>小計</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($details as $detail) { ?>
                    <tr>
                        <td><?php print(h($detail['name'])); ?></td>
                        <td><?php print(h($detail['price'])); ?>円</td>
                        <td><?php print(h($detail['amount'])); ?>個</td>
                        <td><?php print(h($detail['subtotal'])); ?>円</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>