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
                        <th>購入詳細表示</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($histories as $history) { ?>
                        <tr>
                            <td>NO.<?php print(h($history['order_id'])); ?></td>
                            <td><?php print(h($history['created'])); ?></td>
                            <td>計.<?php print(h($history['total'])); ?>円</td>
                            <form method='post' action='details.php'>
                                <input type='submit' value='購入詳細表示'>
                                <input type='hidden' name='order_id' value='<?php print(h($history['order_id'])); ?>'>
                                <input type='hidden' name='token' value='<?php print $token ?>'>
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