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

        <table>
            <thead>
                <tr>
                    <th>注文番号</th>
                    <th>購入日時</th>
                    <th>合計金額</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($histories as $history) { ?>
                    <tr>
                        <td><?php print($history['order-id']); ?></td>
                        <td><?php print($history['created']); ?></td>
                        <td><?php print($history['total']); ?></td>
                        <td>
                            <form method='post' action='detail.php'>
                                <input type='submit' value='購入詳細表示'>
                                <input type='hidden' name='order_id' value='<?php print($history['order_id']); ?>'>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <table>
            <thead>
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
                        <td><?php print($detail['name']); ?></td>
                        <td><?php print($detail['price']); ?></td>
                        <td><?php print($detail['amount']); ?></td>
                        <td><?php print($detail['sutotal']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
</body>

</html>