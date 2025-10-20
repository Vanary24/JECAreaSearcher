<?php
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    // 店舗DAOの接続
    require_once 'DAO/storeDAO.php';
    require_once 'DAO/searchDAO.php';


    if (isset($_GET['keyword'])) {
        $keyword = $_GET['keyword'];

        //　検索の処理・・・
    
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>検索結果</title>
    <link rel="stylesheet" href="./helper/bootstrap-5.0.0-dist/css/bootstrap.min.css">
</head>
<body>
    <?php if (!preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "header.php";
    ?>

    <div class="container-fulid">
        <h2>検索結果</h2>
        <div class="row">
            <div class="col-md-12">
                <p>キーワード: <?php echo htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </div>
    </div>

    <?php } else {
        include "footer.php";
    } ?>
</body>
</html>