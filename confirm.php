<?php
require_once 'DAO/adminDAO.php';
require_once 'DAO/storeDAO.php';
require_once 'DAO/hashtagDAO.php';
require_once 'DAO/imageDAO.php';

$user_agent = $_SERVER['HTTP_USER_AGENT'];
$admin_imgDAO = new Admin_imageDAO();
$admin_tagDAO = new Admin_hashtagDAO();
$storeDAO = new StoreDAO();
$hashtagDAO = new hashtagDAO();
$imageDAO = new imageDAO();


if (isset($_GET['id']) && isset($_GET['name']) && isset($_GET['address']) && isset($_GET['tel']) && isset($_GET['worktime']) && isset($_GET['price']) && isset($_GET['no'])) {
    $id = $_GET['id'];
    $name = $_GET['name'];
    $address = $_GET['address'];
    $tel = $_GET['tel'];
    $worktime = $_GET['worktime'];
    $price = $_GET['price'];
    $no = $_GET['no'];


    $tmpimgs = $admin_imgDAO->get_image($id);
    $tmptags = $admin_tagDAO->get_hashtag($id);

    $tags = [];
    foreach ($tmptags as $tag) {
        $tags[] = $tag["tmp_hashtag_name"];
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        if (isset($_POST["add"])) {
            $storeDAO->store_insert($name, $address, $tel, $worktime, $price, $no);
            $store_id = $storeDAO->get_store_id($address);
            foreach ($tags as $tag) {
                $hashtagDAO->hashtag_name_insert($tag);
                $hashtag_id = $hashtagDAO->hashtag_id_search($tag);
                $hashtagDAO->hashtag_insert($store_id, $hashtag_id);
            }
            foreach ($tmpimgs as $img) {
                $imageDAO->image_insert($store_id, $img);
            }

            header('Location:admin.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>店舗追加確認</title>
    <link rel="stylesheet" href="./helper/bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="./helper/bootstrap-5.0.0-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./css/store_add.css">
</head>

<body>
    <?php if (!preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "header.php";
    } ?>

    <div class="container mt-3">

        <div class="border border-info-subtle rounded-3 w-auto">
            <div class="d-flex justify-content-center align-items-center position-relative">
                <div class="m-2 w-75">
                    <div class="text-center">
                        <h3 class="my-2">店舗追加確認</h3>
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label">店舗名</label>
                            <p><?= $name ?></p>
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label">住所</label>
                            <p><?= $address ?></p>
                        </div>

                        <div class="col-md-6">
                            <label for="tel" class="form-label">電話番号</label>
                            <p><?= $tel ?></p>
                        </div>

                        <div class="col-sm-6">
                            <label for="range" class="form-label">平均予算</label>
                            <p><?= $price ?></p>
                        </div>

                        <div class="col-6">
                            <label class="form-label">営業時間</label>
                            <p><?= $worktime ?></p>
                        </div>



                        <div class="col-sm">
                            <label class="form-label">ハッシュタグ</label>
                            <div>
                                <?php foreach ($tmptags as $tag) { ?>
                                    <span><?= $tag["tmp_hashtag_name"] ?>　</span>
                                <?php } ?>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">画像</label>
                            <div>
                                <?php foreach ($tmpimgs as $img) { ?>
                                    <img src="./images/upload/<?= $img["tmp_store_photo"] ?>" alt="<?= $img["tmp_store_photo"] ?>" width="250">
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="text-center row">
                        <form action="./admin.php" class="col-6">
                            <button type="submit" class="mt-4 btn btn-secondary w-100">戻る</button>
                        </form>
                        <form action="" method="post" class="col-6">
                            <button type="submit" class="mt-4 btn btn-primary w-100" name="add">送信</button>
                        </form>

                    </div>
                </div>
                <div class="position-absolute top-0 start-0 w-auto m-2">

                </div>

            </div>
        </div>

    </div>

    <?php if (preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "footer.php";
    } ?>