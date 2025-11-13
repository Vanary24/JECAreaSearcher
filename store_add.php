<?php
require_once 'DAO/adminDAO.php';
$user_agent = $_SERVER['HTTP_USER_AGENT'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['store_name']) && isset($_POST['store_address']) && isset($_POST['store_tel']) && isset($_POST['store_open']) &&
        isset($_POST['store_close']) && isset($_POST['store_tag']) && isset($_POST['buildingNo'])
    ) {
        $name = $_POST['store_name'];                                   // 店舗名
        $address = $_POST['store_address'];                             // 住所
        $tel = $_POST['store_tel'];                                     // 電話番号
        $time = $_POST['store_open'] . '～' . $_POST['store_close'];    // 営業時間
        $buildingNo = $_POST['buildingNo'];                             // 号館
        $tags = $_POST['store_tag'];                                    // タグ

        if (isset($_POST['store_avgcost'])) {
            $cost = $_POST['store_avgcost'];                            // 予算
        } else {
            $cost = "";
        }

        $store_image = [];                                              // 画像
        if (isset($_FILES['image']) && is_array($_FILES['image']['name'])) {
            $totalFiles = count($_FILES['image']['name']);

            for ($i = 0; $i < $totalFiles; $i++) {
                $fileName = $_FILES['image']['name'][$i];
                $fileTmpName = $_FILES['image']['tmp_name'][$i];
                $fileError = $_FILES['image']['error'][$i];

                // アップロードされた写真の名前を変更
                $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                $newName = uniqid() . '.' . $extension;
                $newPath = 'images/upload/' . $newName;
                array_push($store_image, $newName);

                if ($fileError === UPLOAD_ERR_OK) {
                    move_uploaded_file($fileTmpName, $newPath);
                }
            }
        }
        
        $admin = new AdminDAO();
        $admin_image = new Admin_imageDAO();
        $admin_hashtag = new Admin_hashtagDAO();
        $admin->admin_insert($name, $address, $tel, $time, $cost, $buildingNo);
        $result = $admin->get_admin_id($name);
        $admin_id = (int)$result["admin_id"];
        foreach ($store_image as $img) {
            $admin_image->image_insert($admin_id, $img);
        }
        foreach ($tags as $tag) {
            $admin_hashtag->hashtag_insert($admin_id, $tag);
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
    <script src="./helper/jQuery/jquery-3.6.0.min.js"></script>
    <script src="./helper/jQuery/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/libphonenumber-js/1.11.4/libphonenumber-js.min.js"></script>
</head>

<body>
    <?php if (!preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "header.php";
    } ?>

    <div class="container mt-3">
        <form action="" method="post" enctype="multipart/form-data" id="form">
            <div class="border border-info-subtle rounded-3 w-auto">
                <div class="d-flex justify-content-center align-items-center position-relative">
                    <div class="m-2 w-75">
                        <div class="text-center">
                            <h3 class="my-2">店舗追加</h3>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label">店舗名</label>
                                <input type="text" name="store_name" id="name" class="form-control" required autofocus data-error_placement="#nameError">
                                <div id="nameError"></div>
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">住所</label>
                                <input type="text" name="store_address" id="address" class="form-control" placeholder="東京都〇〇区〇丁目〇－〇" required data-error_placement="#addressError">
                                <div id="addressError"></div>
                            </div>

                            <div class="col-md-6">
                                <label for="tel" class="form-label">電話番号</label>
                                <input type="tel" name="store_tel" id="tel" class="form-control" pattern="0[1-9]{3}[0-9]{6}" maxlength="10" placeholder="0X-XXXX-XXXX" required data-error_placement="#telError">
                                <div id="telError"></div>
                            </div>

                            <div class="col-sm-6">
                                <label for="range" class="form-label">平均予算</label>
                                <input type="text" name="store_avgcost" id="range" class="form-control" placeholder="1000">
                            </div>

                            <div class="col-6">
                                <label class="form-label">営業時間</label>
                                <input type="time" name="store_open" class="form-control" placeholder="営業時間" required data-error_placement="#openError">
                                <div id="openError"></div>
                            </div>

                            <div class="col-6">
                                <label class="form-label">　　　　</label>
                                <input type="time" name="store_close" class="form-control" placeholder="営業時間" required data-error_placement="#closeError">
                                <div id="closeError"></div>
                            </div>

                            <div class="col">
                                <label class="form-label">
                                    ハッシュタグ（最大３つまで）
                                    <button type="button" name="tag" class="tag-add">
                                        <svg xmlns="http://www.w3.org/2000/svg" id="add" width="20" height="20" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                        </svg>
                                    </button>
                                </label>
                                <div class="d-flex align-items-center" id="tag">
                                    <input type="text" name="store_tag[]" class="form-control mx-2" required data-error_placement="#tagError">
                                </div>
                                <div id="tagError"></div>
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
                        <select name="buildingNo" class="form-control text-center" required data-error_placement="#buildingNoError">
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
                    <div class="position-absolute w-auto m-2 buildError">
                        <div id="buildingNoError"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php if (preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "footer.php";
    } ?>

    <script>
        // 画像のプレビュー処理
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

        // タグの追加処理
        $(function() {
            let count = 1;

            $('#add').on('click', function() {
                const input = $('<input>').attr('type', 'text').attr('name', 'store_tag[]').addClass('form-control me-2');
                $('#tag').append(input);
                count++;
                console.log(count);

                if (count >= 3) {
                    $('#add').css('display', 'none');
                }
            });
        })

        // 電話番号のハイフン処理
        document.addEventListener('DOMContentLoaded', function() {
            const telInputs = document.querySelectorAll('input[type="tel"]');
            const tel = document.getElementById('tel')

            telInputs.forEach(function(input) {
                input.addEventListener('blur', function(event) {
                    event.target.value = new libphonenumber.AsYouType('JP').input(event.target.value);
                    console.log(event.target.value);
                });

                input.addEventListener('focus', function(e) {
                    const value = e.target.value;
                    const newValue = value.replace(/-/g, '');

                    e.target.value = newValue;
                });
            });
        }, false);

        // 入力フォームのバリデーションチェック
        $(function() {
            $('#form').validate({
                errorClass: "Error",
                errorElement: "span",
                errorPlacement: function(error, element) {
                    error.appendTo(element.data('error_placement'));
                },
                rules: {
                    store_name: {
                        required: true,
                    },
                    store_address: {
                        required: true,
                    },
                    store_tel: {
                        required: true,
                        maxlength: 12,
                    },
                    store_open: {
                        required: true,
                    },
                    store_close: {
                        required: true,
                    },
                    "store_tag[]": {
                        required: true,
                    },
                    buildingNo: {
                        required: true,
                    },
                },
                messages: {
                    store_name: {
                        required: '店舗名を入力してください',
                    },
                    store_address: {
                        required: '住所を入力してください',
                    },
                    store_tel: {
                        required: '電話番号を入力してください',
                        maxlength: '10桁の電話番号を入力してください'
                    },
                    store_open: {
                        required: '開店時刻を入力してください',
                    },
                    store_close: {
                        required: '閉店時刻を入力してください',
                    },
                    "store_tag[]": {
                        required: 'タグを入力してください',
                    },
                    buildingNo: {
                        required: '号館を選択してください',
                    },
                },
            });
        });
    </script>
</body>

</html>