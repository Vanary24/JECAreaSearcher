<?php
require_once './DAO/MemberDAO.php';
require_once './DAO/storeDAO.php';
require_once './DAO/favoriteDAO.php';

$user_agent = $_SERVER['HTTP_USER_AGENT'];

session_start();

if (!empty($_SESSION['member'])) {
    $member = $_SESSION['member'];
}

if (isset($_GET['keyword'])) {
    $keyword = htmlspecialchars($_GET['keyword']);

    $search = new storeDAO();
    $stores = $search->search_by_keyword($keyword);
    $count = $search->search_count($keyword);
}

$favorite = new favoriteDAO();
$favo_list = $favorite->get_store_id($member->member_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['store_id'])) {
        $store_id = $_POST['store_id'];
    }
    if (isset($_POST['fav_star_fill'])) {
        $favorite->insert_favorite($member->member_id, $store_id);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>検索結果</title>
    <link rel="stylesheet" href="./helper/bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="./helper/bootstrap-5.0.0-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./css/search_result.css">
</head>

<body>
    <?php if (!preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "header.php";
    } ?>
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
                        <div class="col-3 text-center position-relative">
                            <img src="./images/shop.png" width="300">
                            <div class="position-absolute top-0 start-0 mt-1 ms-1">
                                <form action="" method="post">
                                    <?php if (in_array($store->store_id, $favo_list)) { ?>
                                        <input type="hidden" name="store_id" value="<?= $store->store_id ?>">
                                        <button type="submit" name="fav_star_fill" class="star-fill">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                            </svg>
                                        </button>
                                    <?php } else { ?>
                                        <button type="submit" name="fav_star" class="star">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z" />
                                            </svg>
                                        </button>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                        <div class="col-5 mx-2">
                            <div class="m-1 p-2">
                                <h3><?= $store->store_name ?></h3>
                                <p class="lead text-primary mt-3">＃<?= $store->hashtag_name ?></p>
                                <p>
                                    <span class="text-secondary me-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                                        </svg>
                                    </span>
                                    <?= $store->store_address ?>
                                </p>
                            </div>
                        </div>

                    </div>
            <?php }
            } ?>
        </div>
    <?php if (preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "footer.php";
    } ?>
</body>

</html>