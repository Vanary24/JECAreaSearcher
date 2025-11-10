<?php
$user_agent = $_SERVER['HTTP_USER_AGENT'];
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
    
    <p>店舗名：<?$name?></p>
    <p>住所：<?$address?></p>
    <p>電話番号：<?$tel?></p>
    <p>営業時間：<?$open?>〜<?$close?></p>
    <p>平均価格：<?$avgcost?></p>
    <p>号館：<?$buildingNo?></p>
    <p>ハッシュタグ：<?$tags?></p>
    <?foreach($store_image as $img){ ?>
        <p>画像ファイル名：<?$img?></p>
    <?}?>
    <?php if (preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "footer.php";
    } ?>
</body>

</html>