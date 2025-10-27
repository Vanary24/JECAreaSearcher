<?php
$user_agent = $_SERVER['HTTP_USER_AGENT'];

require_once './DAO/storeDAO.php';
require_once './DAO/hashtagDAO.php';
require_once './DAO/imageDAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['store_name']) && isset($_POST['store_address']) && isset($_POST['store_tel']) && isset($_POST['store_open']) && isset($_POST['store_open']) &&
        isset($_POST['store_close']) && isset($_POST['store_tag']) && isset($_POST['buildingNo'])) {
        $name = $_POST['store_name'];
        $address = $_POST['store_address'];
        $tel = $_POST['store_tel'];
        $open = $_POST['store_open'];
        $close = $_POST['store_close'];
        $avgcost = $_POST['store_avgcost'];
        $buildingNo = $_POST['buildingNo'];
        $tags = $_POST['store_tag'];

    }

    if (isset($_FILES['image']) && is_array($_FILES['image']['name'])) {
        $totalFiles = count($_FILES['image']['name']);

        for ($i = 0; $i < $totalFiles; $i++) {
            $fileName = $_FILES['image']['name'][$i];
            $fileTmpName = $_FILES['image']['tmp_name'][$i];
            $fileError = $_FILES['image']['error'][$i];
            array_push($store_image, $fileName);

            if ($fileError === UPLOAD_ERR_OK) {
                $destination = 'images/upload/' . basename($fileName);
                move_uploaded_file($fileTmpName, $destination);
            }
        }
    }

    $store = new StoreDAO();
    $hashtag = new hashtagDAO();
    $image = new imageDAO();
}
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