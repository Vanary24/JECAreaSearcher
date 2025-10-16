<?php
$user_agent = $_SERVER['HTTP_USER_AGENT'];


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>ルーレット</title>
    <link rel="stylesheet" href="./bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/roulette.css">
    <script src="./bootstrap-5.0.0-dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/roulette.js"></script>
</head>

<body>
    <?php if (!preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "header.php";
    ?>
        <div class="container-fulid mt-3">

            <form>
                <div class="d-flex justify-content-around align-items-center botton">

                    <div class="favorite mb-2">
                        <button onclick="drawRoulette()" name="favorite">お気に入り</button>
                    </div>
                    <div class="recommend mb-2">
                        <button onclick="drawRoulette()" name="recommend">おすすめ</button>
                    </div>
                    <div class="result mb-2">
                        <button onclick="drawRoulette()" name="result">検索結果</button>
                    </div>

                </div>
            </form>
            <div id="roulette">
                <div id="pointer"></div>
                <canvas id="canvas"></canvas>
                <button onclick="spinRoulette()" id= "spin">ルーレットを回します</button>
            </div>

            

            

        </div>


    <?php } else {
        include "footer.php";
    } ?>

</body>

</html>
