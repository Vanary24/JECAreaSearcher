<?php
session_start();

if (isset($_POST['destory'])) {
    session_destroy();
    header('Location:login.php');
    exit;
}

if (empty($_SESSION['member'])) {
    header('Location:login.php');
    exit;
} else {
    $member = $_SESSION['member'];
}

$user_agent = $_SERVER['HTTP_USER_AGENT'];



if (isset($_GET['buildingNo'])) {
    $buildingNo = $_GET['buildingNo'];

    if ($buildingNo === "1") {
        $recommend = ['お店1', 'お店2', 'お店3', 'お店4', 'お店5'];
    }
}

if (isset($_POST['fav_star'])) {
    //お気に入り削除の処理
}
    $favorite = ['お店1', 'お店2', 'お店3', 'お店4', 'お店5'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ホーム</title>
    <link rel="stylesheet" href="./helper/bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/index.css">
    <script src="./helper/bootstrap-5.0.0-dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php if (!preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "header.php";
    } ?> 
    <div class="container-fulid mt-3">
        <div class="row mb-2 ms-1 me-1 position-relative">
            <div class="col-md-6">
                <div class="text-center">
                    <button class="btn_h btn-success dropdown-toggle mt-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        号館を選択してください
                    </button>
                    <ul class="dropdown-menu buliding-select">
                        <li><a class="dropdown-item" href="index.php?buildingNo=1">1号館</a></li>
                        <li><a class="dropdown-item" href="index.php?buildingNo=2">2号館</a></li>
                    </ul>
                </div>
                
                <hr>
                <?php if (!empty($recommend)) { ?>
                    <?php foreach ($recommend as $rec) { ?>
                        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-1 shadow-sm h-md-250 position-relative w-75 mx-auto">
                            <div class="col-auto d-none d-lg-block">
                                <img src="./images/shop.png" alt="お店の画像" width="300">
                            </div>
                            <div class="col p-4 d-flex justify-content-center flex-column position-static text-center">
                                <h3 class="mb-0"><?= $rec ?></h3>
                                <div class="mb-1 text-body-secondary">距離</div>
                                <a href="#" class="icon-link gap-1 icon-link-hover stretched-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="col-md-6 mt-2">
                <div class="a text-center">
                    <h3>お気に入りのお店</h3>
                </div>
                
                <hr>
                <?php if (!empty($favorite)) { 
                    foreach ($favorite as $fav) { ?>
                        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-1 shadow-sm h-md-250 position-relative w-75 mx-auto">
                            <div class="col-auto d-none d-lg-block">
                                <img src="./images/shop.png" alt="お店の画像" width="300">
                            </div>
                            <div class="col p-4 d-flex justify-content-center flex-column text-center">
                                <h3 class="mb-0"><?= $fav ?></h3>
                                <div class="mb-1 text-body-secondary">距離</div>
                                <a href="#" class="icon-link gap-1 icon-link-hover stretched-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                    </svg>
                                </a>
                            </div>
                            <div class="position-absolute top-0 start-0 mt-1 ms-1">
                                <form action="" method="post">
                                    <button type="submit" name="fav_star" class="star">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                <?php } }?>
            </div>

            <div class="position-absolute top-0 start-50 translate-middle-x mt-1 w-auto">
                <form action="./store_add.php" method="post">
                    <button type="submit" class="btn_h btn-success">
                        お店の追加
                    </button>
                </form>
            </div>

            <div class="position-absolute top-0 start-0 w-auto">
                <form action="" method="post">
                    <button type="submit" name="destory">
                        ログアウト
                    </button>
                </form>
            </div>
        </div>
        
        
    </div>
    <?php if (preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "footer.php";
    } ?>
</body>

</html>