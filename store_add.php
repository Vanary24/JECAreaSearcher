<?php
$user_agent = $_SERVER['HTTP_USER_AGENT'];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>店舗追加</title>
    <link rel="stylesheet" href="./helper/bootstrap-5.0.0-dist/css/">
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
                                    <label class="filelabel my-3 bg-primary border border-primary">
                                        <span class="" title="ファイルを選択">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="26" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                                <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1z" />
                                            </svg>
                                            写真
                                        </span>
                                        <input type="file" id="filesend" name="image[]" multiple accept=".jpg,.png,image/jped,image/png">
                                    </label>
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

    <script>
        const 
    </script>
</body>

</html>