<?php
require_once './DAO/MemberDAO.php';
require_once './DAO/storeDAO.php';
require_once './DAO/favoriteDAO.php';
require_once './DAO/hashtagDAO.php';

$user_agent = $_SERVER['HTTP_USER_AGENT'];

session_start();


$storeDAO = new storeDAO();
$hashtagDAO = new hashtagDAO();

if (!empty($_SESSION['member'])) {
    $member = $_SESSION['member'];
}

if (isset($_GET['store_goukann'])) {
    $goukan = $_GET['store_goukann'];
}

if (isset($_GET['keyword'])) {
    $keyword = htmlspecialchars($_GET['keyword']);
    $stores = $storeDAO->search_by_keyword($keyword, $goukan);
}

if (!empty($_GET['store_tag'][0])) {
    $store_tag = $_GET['store_tag'];
    $stores = $hashtagDAO->search_by_hashtag($store_tag, $goukan, $keyword);
}

if (!empty($stores)) {
    $counts_list = [];
    foreach ($stores as $s) {
        $counts_list[] = $s["store_id"];
    }
    $counts = count(array_unique($counts_list));
} else {
    $counts = 0;
}




// お気に入りのお店を取得
$favorite = new favoriteDAO();
$favo = $favorite->get_store_id($member->member_id);
$favo_list = [];
foreach ($favo as $f) {
    $favo_list[] = $f["store_id"];
}

// お気に入りの追加と削除
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['store_id'])) {
        $store_id = $_POST['store_id'];
    }
    if (isset($_POST['fav_bm'])) {
        $favorite->insert_favorite($member->member_id, $store_id);
        $favo = $favorite->get_store_id($member->member_id);
        $favo_list = [];
        foreach ($favo as $f) {
            $favo_list[] = $f["store_id"];
        }
    }
    if (isset($_POST['fav_bm_fill'])) {
        $favorite->delete_favorite($member->member_id, $store_id);
        $favo = $favorite->get_store_id($member->member_id);
        $favo_list = [];
        foreach ($favo as $f) {
            $favo_list[] = $f["store_id"];
        }
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
            <p class="fw-bold fs-3">検索結果：<?= @$counts ?> 件</p>
        </div>
        <hr>
        <?php if (empty($stores)) { ?>
            <p class="fw-bold fs-2">検索したお店はありません。</p>
            <?php } else {
            foreach ($stores as $store) { ?>
                <div class="row g-4 my-2 mx-5 py-2 justify-content-center">
                    <div class="col-3 text-center position-relative">
                        <img src="./images/shop.png" width="300">
                        <div class="position-absolute top-0 start-0 mt-1 ms-1">
                            <form action="" method="post">
                                <input type="hidden" name="store_id" value="<?= $store["store_id"] ?>">
                                <?php if (in_array($store["store_id"], $favo_list)) { ?>
                                    <button type="submit" name="fav_bm_fill" class="bm-fill">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bookmark-fill" viewBox="0 0 16 16">
                                            <path d="M2 2v13.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2" />
                                        </svg>
                                    </button>
                                <?php } else { ?>
                                    <button type="submit" name="fav_bm" class="bm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bookmark" viewBox="0 0 16 16">
                                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z" />
                                        </svg>
                                    </button>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                    <div class="col-4 mx-2">
                        <div class="m-1 p-2">
                            <h3><?= $store["store_name"] ?></h3>
                            <p class="lead text-primary mt-3">＃
                                <?php foreach ($hashtagDAO->get_hashtag_name($store["store_id"]) as $tag) { ?>
                                    <span><?= $tag["hashtag_name"] ?>　</span>
                                <?php } ?>
                            </p>
                            <p>
                                <span class="text-secondary me-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                                    </svg>
                                </span>
                                <?= $store["store_address"] ?>
                            </p>
                            <a href="./store_detail.php?store_id=<?= $store["store_id"] ?>" class="">→</a>
                        </div>
                    </div>
                </div>
                <hr>
        <?php }
        } ?>
    </div>
    <?php if (preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "footer.php";
    } ?>
</body>

</html>