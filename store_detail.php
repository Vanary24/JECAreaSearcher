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
                    <img src="./images/house.svg" alt="画像" class="w-50">
                    <p>スライドショー</p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="m-1 p-2">
                    <h3>店舗名</h3>
                    <p class="d-flex justify-content-between mt-3 fs-5">
                        <span class="me-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                            </svg>
                            住所
                        </span>

                        <a href="https://www.google.com/maps/search/?api=1&query=モス">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-map" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15.817.113A.5.5 0 0 1 16 .5v14a.5.5 0 0 1-.402.49l-5 1a.5.5 0 0 1-.196 0L5.5 15.01l-4.902.98A.5.5 0 0 1 0 15.5v-14a.5.5 0 0 1 .402-.49l5-1a.5.5 0 0 1 .196 0L10.5.99l4.902-.98a.5.5 0 0 1 .415.103M10 1.91l-4-.8v12.98l4 .8zm1 12.98 4-.8V1.11l-4 .8zm-6-.8V1.11l-4 .8v12.98z" />
                            </svg>
                        </a>
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