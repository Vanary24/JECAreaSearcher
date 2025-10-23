<?php
$user_agent = $_SERVER['HTTP_USER_AGENT'];
require_once './DAO/storeDAO.php';
require_once './DAO/hashtagDAO.php';
require_once './DAO/imageDAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['goukan']) && isset($_POST['store_name']) && isset($_POST['store_address']) && isset($_POST['store_tel1']) && isset($_POST['store_tel2']) && isset($_POST['store_tel3'])
        && isset($_POST['store_open']) && isset($_POST['store_close']) && isset($_POST['store_tag1']) && isset($_POST['store_tag2']) && isset($_POST['store_tag3'])
    ) {
        $goukan = $_POST['goukan'];
        $store_name = $_POST['store_name'];
        $store_address = $_POST['store_address'];
        $store_tel = $_POST['store_tel1'] . '-' . $_POST['store_tel2'] . '-' . $_POST['store_tel3'];
        $store_avgcost = $_POST['store_avgcost'];
        $store_worktime = $_POST['store_open'].'～'.$_POST['store_close'];
        $store_tag1 = $_POST['store_tag1'];
        $store_tag2 = $_POST['store_tag2'];
        $store_tag3 = $_POST['store_tag3'];
        $store_image = [];

        if (isset($_FILES['image']) && is_array($_FILES['image']['name'])) {
            $totalFiles = count($_FILES['image']['name']);

            for ($i = 0; $i < $totalFiles; $i++) {
                $fileName = $_FILES['image']['name'][$i];
                $fileTmpName = $_FILES['image']['tmp_name'][$i];
                $fileError = $_FILES['image']['error'][$i];
                array_push($store_image, $fileName);

                if ($fileError === UPLOAD_ERR_OK) {
                    $destination = 'images/upload/' . basename($fileName);
                    move_uploaded_file($fileTmpName, $destination);
                }
            }
        }

        $store = new StoreDAO();
        $hashtag = new hashtagDAO();
        $image = new imageDAO();

        if(isset($store_tag1)){
            $store_hashtag[] = $_POST['store_tag1'];
        }
        if(isset($store_tag2)){
            $store_hashtag[] = $_POST['store_tag2'];
        }
        if(isset($store_tag3)){
            $store_hashtag[] = $_POST['store_tag3'];
        }
        

        foreach($store_hashtag as $store_hashtag2);{
            $hashtag->hashtag_name_insert($store_hashtag2);
            
          $hashtag_id[] = $hashtag->hashtag_id_search($store_hashtag2);
        }

        $store->store_insert($store_name,$store_address,$store_tel,$store_worktime,$store_avgcost,$goukann);

        $store_id = $store->get_store_id_by_store_address($store_address);

        
        foreach($hashtag_id as $hashtag_id2){
           
            $hashtag->hashtag_insert($store_id,$hashtag_id2);
        }
        
        foreach($store_image as $store_image2){
            $image->image_insert($store_id,$store_image2);

        }

        header("Location:" . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>店舗追加</title>
    <link rel="stylesheet" href="./helper/bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="./helper/bootstrap-5.0.0-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./css/store_add.css">
    <script src="./js/store_add.js"></script>
    <script src="./helper/jQuery/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php if (!preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "header.php";
    ?>

        <div class="container mt-3">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="border border-info-subtle rounded-3 w-auto">
                    <div class="d-flex justify-content-center align-items-center position-relative">
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
                                    <input type="text" name="store_avgcost" id="range" class="form-control" placeholder="1000">
                                </div>

                                <div class="col-4">
                                    <label class="form-label">営業時間</label>
                                    <input type="time" name="store_open" class="form-control" placeholder="営業時間" required>

                                </div>
                                <div class="col-4">
                                    <label class="form-label">　　　　</label>
                                    <input type="time" name="store_close" class="form-control" placeholder="営業時間" required>
                                </div>
                                <div class="tag position-relative" id="tagarea">
                                    <label for="tag" class="form-label">ハッシュタグ（最大３つまで）</label>
                                    <div class="d-flex align-items-center">
                                        <input type="text" name="store_tag1" id="tag" class="form-control me-2" required>
                                        <input type="text" name="store_tag2" id="tag2" class="form-control me-2">
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
                                <div id="preview"></div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="mt-4 btn btn-primary w-100">送信</button>
                            </div>
                        </div>
                        <div class="position-absolute top-0 start-0 w-auto m-2">
                            <select name="goukan" class="form-control text-center" required>
                                <option disabled selected value>号館</option>
                                <option value="1">1号館</option>
                                <option value="2">2号館</option>
                                <option value="3">3号館</option>
                                <option value="4">4号館</option>
                                <option value="5">5号館</option>
                                <option value="6">6号館</option>
                                <option value="7">7号館</option>
                                <option value="8">8号館</option>
                                <option value="9">9号館</option>
                                <option value="10">10号館</option>
                                <option value="11">11号館</option>
                                <option value="12">12号館</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    <?php } else {
        include "footer.php";
    } ?>

    <script>
        $(document).ready(function() {
            $('#filesend').on('change', function(event) {
                $('#preview').empty();

                const files = event.target.files;
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const img = $('<img>').attr('src', e.target.result).attr('width', '250px').addClass('me-2 mb-2');
                        $('#preview').append(img);
                    }

                    reader.readAsDataURL(file);
                }

                $('#preview').css('display', 'block');
            });
        });
    </script>
</body>

</html>