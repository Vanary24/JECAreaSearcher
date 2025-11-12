<?php
require_once 'DAO/adminDAO.php';

$user_agent = $_SERVER['HTTP_USER_AGENT'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['address']) && isset($_POST['tel']) && isset($_POST['worktime']) && isset($_POST['price']) && isset($_POST['no'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $tel = $_POST['tel'];
        $worktime = $_POST['worktime'];
        $price = $_POST['price'];
        $no = $_POST['no'];
        $tags = [];
        $imgs = [];

        $admin_imgDAO = new Admin_imageDAO();
        $admin_tagDAO = new Admin_hashtagDAO();
        foreach ($admin_imgDAO->get_image($id) as $img) {
            $imgs[] = (string)$img;
        }

        foreach ($admin_tagDAO->get_hashtag($id) as $tag) {
            $tags[] = (string)$tag;
        }

        var_dump($imgs);
        var_dump($tags);
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>店舗追加</title>
    <link rel="stylesheet" href="./helper/bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="./helper/bootstrap-5.0.0-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./css/store_add.css">
</head>

<body>
    <?php if (!preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "header.php";
    } ?>

    <div class="container mt-3">
        <form action="" method="post">
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
                                
                            </div>
                            <div>
                                <label class="form-label">画像</label>
                                
                            </div>
                            <div id="preview"></div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="mt-4 btn btn-primary w-100">送信</button>
                        </div>
                    </div>
                    <div class="position-absolute top-0 start-0 w-auto m-2">

                    </div>

                </div>
            </div>
        </form>
    </div>

    <?php if (preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "footer.php";
    } ?>