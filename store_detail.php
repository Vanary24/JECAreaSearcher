<?php
$user_agent = $_SERVER['HTTP_USER_AGENT'];

require_once './DAO/storeDAO.php';

$storeDAO = new StoreDAO();

if (isset($_GET['store_id'])) {
    $store_id = $_GET['store_id'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>お店詳細</title>
    <link rel="stylesheet" href="./helper/bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="./helper/bootstrap-5.0.0-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./css/store_detail.css">
</head>

<body>
    <?php if (!preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "header.php";
    } ?>

    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-6">
                <div class="card shadow-sm justify-content-center align-items-center">
                    <img src="./images/shop.png" alt="画像" class="w-auto">
                    <p>スライドショー</p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="m-1 p-2">
                    <h3>店舗名</h3>
                    <p class="d-flex justify-content-between align-items-center mt-3 fs-5">
                        <span class="me-1">
                            住所：
                        </span>

                        <a href="https://www.google.com/maps/search/?api=1&query=モス" class="map">
                            <img src="./images/google map.svg" alt="map" width="50" height="50">
                        </a>
                    </p>
                    <p class="mt-3 fs-5">
                        電話：
                    </p>
                    <p class="mt-3 fs-5">
                        営業時間：
                    </p>
                    <p class="mt-3 fs-5">
                        平均予算：
                    </p>
                </div>
                <div class="mx-1 mt-5 p-2 text-primary">
                    <h5 class="mb-2">
                        ＃タグ：
                    </h5>
                    <p>
                        タグ1　タグ2
                    </p>
                </div>
            </div>
        </div>
    </div>

    <?php if (preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "footer.php";
    } ?>
</body>

</html>