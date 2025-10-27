<?php



require_once './DAO/storeDAO.php';
require_once './DAO/hashtagDAO.php';
require_once './DAO/imageDAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['goukan']) && isset($_POST['store_name']) && isset($_POST['store_address']) && isset($_POST['store_tel1']) && isset($_POST['store_tel2']) && isset($_POST['store_tel3'])
        && isset($_POST['store_open']) && isset($_POST['store_close']) && isset($_POST['store_tag1']) && isset($_POST['store_tag2']) && isset($_POST['store_tag3'])
    ) {
        // store_add.phpから送信された店舗情報を受け取る
        $goukan = $_POST['goukan'];
        $store_name = $_POST['store_name'];
        $store_address = $_POST['store_address'];
        $store_tel = $_POST['store_tel1'] . '-' . $_POST['store_tel2'] . '-' . $_POST['store_tel3'];
        $store_avgcost = $_POST['store_avgcost'];
        $store_worktime = $_POST['store_open'] . '～' . $_POST['store_close'];
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

        if (isset($store_tag1)) {
            $store_hashtag[] = $_POST['store_tag1'];
        }
        if (isset($store_tag2)) {
            $store_hashtag[] = $_POST['store_tag2'];
        }
        if (isset($store_tag3)) {
            $store_hashtag[] = $_POST['store_tag3'];
        }


        foreach ($store_hashtag as $store_hashtag2); {
            $hashtag->hashtag_name_insert($store_hashtag2);

            $hashtag_id[] = $hashtag->hashtag_id_search($store_hashtag2);
        }

        $store->store_insert($store_name, $store_address, $store_tel, $store_worktime, $store_avgcost, $goukann);

        $store_id = $store->get_store_id_by_store_address($store_address);


        foreach ($hashtag_id as $hashtag_id2) {

            $hashtag->hashtag_insert($store_id, $hashtag_id2);
        }

        foreach ($store_image as $store_image2) {
            $image->image_insert($store_id, $store_image2);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>管理者画面</title>
</head>
<body>
    <?php if (!preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "header.php";
    } ?>
    
</body>
</html>