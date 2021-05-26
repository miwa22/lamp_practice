<!DOCTYPE html>
<html lang='ja'>

<head>
    <?php include VIEW_PATH . 'templates/head.php'; ?>
    <title>購入履歴</title>
    <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'admin.css'); ?>">
</head>

<body>
    <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
    <div class='container'>
        <h1>購入履歴</h1>

        <?php include VIEW_PATH . 'templates/messages.php'; ?>

        <?php if (!empty($histories)) { ?>
            <table class='table table-bordered text-center'>
                <thead class='thead-light'>
                    <tr>
                        <th>注文番号</th>
                        <th>購入日時</th>
                        <th>該当の注文合計金額</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($histories as $history) { ?>
                        <tr>
                            <td><?php print($history['order_id']); ?></td>
                            <td><?php print($history['created']); ?></td>
                            <td><?php print($history['total']); ?>円</td>
                            <td>
                                <form method='post' action='detail.php'>
                                    <input type='submit' value='購入詳細表示'>
                                    <input type='hidden' name='order_id' value='<?php print($history['order_id']); ?>'>
                                    <input type='hidden' name='created' value='<?php print($history['created']); ?>'>
                                    <input type='hidden' name='total' value='<?php print($history['total']); ?>'>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>購入履歴がありません。</p>
        <?php } ?>
    </div>
</body>

</html>