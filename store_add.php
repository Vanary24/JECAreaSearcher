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
            <form action="" method="post" enctype="multipart/form-data">
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

                                <div class="col-md-6">
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
                                <div class="tag position-relative" id="tagarea">
                                    <label for="tag" class="form-label">ハッシュタグ（最大３つまで）</label>
                                    <div class="d-flex align-items-center">
                                        <input type="text" name="store_tag1" id="tag" class="form-control me-2" required>
                                        <input type="text" name="store_tag2" class="form-control me-2">
                                        <input type="text" name="store_tag3" class="form-control">
                                    </div>
                                </div>
                                <div>
                                    <label for="img" class="form-label">画像</label>
                                    <input type="file" id="img" name="image[]" multiple class="form-control">
                                </div>
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