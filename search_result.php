<?php
$user_agent = $_SERVER['HTTP_USER_AGENT'];

require_once './DAO/storeDAO.php';

if (isset($_GET['keyword'])) {
    $keyword = htmlspecialchars($_GET['keyword']);

    $search = new storeDAO();
    $stores = $search->search_by_keyword($keyword);
    $count = $search->search_count($keyword);
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>検索結果</title>
    <link rel="stylesheet" href="./helper/bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/search_result.css">
</head>

<body>
    <?php if (!preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "header.php";
    ?>

        <div class="container-fulid mx-4 my-2">
            <div class="text-end">
                <p class="fw-bold fs-3">検索結果：<?= $count ?> 件</p>
            </div>
            <hr>
            <?php if (empty($stores)) { ?>
                <p>検索したお店はありません。</p>
                <?php } else {
                foreach ($stores as $store) { ?>
                    <div class="row row-cols-2 g-4 my-2 mx-5 py-2 justify-content-center">
                        <div class="col-3 text-center">
                            <img src="./images/shop.png" width="300">
                        </div>
                        <div class="col-5 mx-2">
                            <div class="m-1 p-2">
                                <h3><?= $store->store_name ?></h3>
                                <p class="lead text-primary mt-3">＃<?=$store->hashtag_name?></p>
                                <p>
                                    <span class="text-secondary me-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                                        </svg>
                                    </span>
                                    <?=$store->store_address?>
                                </p>
                            </div>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>

    <?php } else {
        include "footer.php";
    } ?>
</body>

</html>