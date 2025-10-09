<?php
$user_agent = $_SERVER['HTTP_USER_AGENT'];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>店舗追加</title>
    <link rel="stylesheet" href="./bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="./bootstrap-5.0.0-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./css/store_add.css">
    <script src="./js/store_add.js"></script>
</head>

<body>
    <?php if (!preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "header.php";
    ?>

        <div class="container mt-3">
            <form action="" method="post">
                <div class="border border-info-subtle rounded-3 w-auto">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="m-2 w-75">
                            <div class="text-center">
                                <h3 class="my-2">店舗追加</h3>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="name" class="form-label">店舗名</label>
                                    <input type="text" name="store_name" id="name" class="form-control" required autofocus>
                                </div>

                                <div class="col-12">
                                    <label for="address" class="form-label">住所</label>
                                    <input type="text" name="store_address" id="address" class="form-control" placeholder="東京都〇〇区〇－〇－〇・・・" required>
                                </div>

                                <div class="col-sm-6">
                                    <label for="tel" class="form-label">電話番号</label>
                                    <div class="d-flex align-items-center tel">
                                        <input type="tel" name="store_tel1" id="tel" class="form-control" maxlength="2" pattern="[0-9]{2}" title="数字2桁" placeholder="XX" required>－
                                        <input type="tel" name="store_tel2" class="form-control" maxlength="4" pattern="[0-9]{4}" title="数字4桁" placeholder="XXXX" required>－
                                        <input type="tel" name="store_tel3" class="form-control" maxlength="4" pattern="[0-9]{4}" title="数字4桁" placeholder="XXXX" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="range" class="form-label">平均予算</label>
                                    <input type="text" name="store_range" id="range" class="form-control" placeholder="1000">
                                </div>

                                <div class="col-12">
                                    <label for="open" class="form-label">営業時間</label>
                                    <input type="text" name="store_open" id="open" class="form-control" placeholder="営業時間" required>
                                </div>
                                <div class="col-4 tag position-relative">
                                    <label for="tag" class="form-label">ハッシュタグ</label>
                                    <input type="text" name="store_tag" id="tag" class="form-control" required>
                                    <button type="button" class="tag-add position-absolute top-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="form-floating mb-1">


                            </div>
                            <div class="form-floating">
                                <input type="text" name="store_name" id="image" class="form-control" placeholder="画像">
                                <label for="image">画像</label>
                            </div>
                        </div>



                    </div>
                </div>
            </form>
        </div>

    <?php } else {
        include "footer.php";
    } ?>
</body>

</html>