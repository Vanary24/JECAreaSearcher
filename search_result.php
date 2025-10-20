<?php
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    require_once './DAO/storeDAO.php';

    if (isset($_GET['keyword'])) {
        $keyword = htmlspecialchars($_GET['keyword']);

        $search = new storeDAO();
        $store = $search->search_by_keyword($keyword);
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
    </div>

    <?php } else {
        include "footer.php";
    } ?>
</body>
</html>