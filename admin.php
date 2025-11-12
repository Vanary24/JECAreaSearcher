<?php
require_once 'DAO/adminDAO.php';

$user_agent = $_SERVER['HTTP_USER_AGENT'];

$adminDAO = new AdminDAO();
$tmp_list = $adminDAO->get_tmp_data();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>管理者画面</title>
    <link rel="stylesheet" href="./helper/bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="./helper/bootstrap-5.0.0-dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style="padding-top: 100px;">
    <?php if (!preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "header.php";
    } ?>

    <div class="container mt-3">
        <div class="d-flex justify-content-around align-items-center">
            <div>
                <h3>お店追加確認</h3>
            </div>
            <div>
                <h3>コメント削除確認</h3>
            </div>
        </div>
        <hr>
        <form action="./confirm.php" method="post">
            <div class="row">
                <div class="col-6">
                    <?php foreach ($tmp_list as $tmp) { ?>
                        <div class="mb-3">
                            <input type="hidden" name="id" value="<?= $tmp->admin_id ?>">
                            <input type="hidden" name="name" value="<?= $tmp->tmp_store_name ?>">
                            <input type="hidden" name="address" value="<?= $tmp->tmp_store_address ?>">
                            <input type="hidden" name="tel" value="<?= $tmp->tmp_store_tel ?>">
                            <input type="hidden" name="worktime" value="<?= $tmp->tmp_store_worktime ?>">
                            <input type="hidden" name="price" value="<?= $tmp->tmp_store_average_price ?>">
                            <input type="hidden" name="no" value="<?= $tmp->tmp_goukann ?>">
                            <button type="submit" class="w-100"><?= $tmp->tmp_store_name ?></button>
                        </div>
                    <?php } ?>
                </div>

                <div class="col-6">
                    コメント1
                </div>

            </div>
        </form>
    </div>

    <?php if (preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "footer.php";
    } ?>
</body>

</html>