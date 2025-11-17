<?php
$user_agent = $_SERVER['HTTP_USER_AGENT'];


?>

<!DOCTYPE html>
<html_entity_decode>

    <head>
        <meta charset="UTF-8">
        <title>詳細検索</title>
        <link rel="stylesheet" href="./helper/bootstrap-5.0.0-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/search_detail.css">
        <link rel="stylesheet" media="(max-width: 800px)" href="small.css"><br><link rel="stylesheet" media="(min-width: 801px)" href="large.css">
        <script src="./helper/jQuery/jquery-3.6.0.min.js"></script>
        <script src="./helper/bootstrap-5.0.0-dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <body>
        <?php if (!preg_match('/Mobile|Android|iPhone/', $user_agent)) {
            include "header.php";
        } ?>
        <form action="./search_result.php" method="get">
            <div class="container-fulid mt-3">
                <div class="text-center">
                    <h3 class="my-2">詳細検索</h3>
                </div>
                <div class="d-flex justify-content-center align-items-center ">

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="keyword" class="form-label">キーワード入力</label>
                            <input type="text" name="store_keyword" id="keyword" class="form-control" placeholder="お店の名前">
                        </div>
                        <div class="col">
                            <label class="form-label">
                                ハッシュタグ入力（最大３つまで）
                                <button type="button" name="tag" class="tag-add">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="add" width="20" height="20" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                    </svg>
                                </button>
                            </label>
                            <div class="d-flex align-items-center" id="tag">
                                <input type="text" name="store_tag[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="">
                                <select name="store_goukann" class="form-control text-center">
                                    <option disabled selected value>号館を選択してください</option>
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
                        <div class="text-center">
                            <button type="submit" class="mt-4 btn btn-primary w-100">送信</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>





        <?php if (preg_match('/Mobile|Android|iPhone/', $user_agent)) {
            include "footer.php";
        } ?>
        <script>
          // タグの追加処理
        $(function() {
            let count = 1;

            $('#add').on('click', function() {
                let input;
                if (count < 3) {
                    input = $('<input>').attr('type', 'text').attr('name', 'store_tag[]').addClass('form-control ms-2');
                } else {
                    input = $('<input>').attr('type', 'text').attr('name', 'store_tag[]').addClass('form-control');
                }

                $('#tag').append(input);
                count++;

                if (count >= 3) {
                    $('.tag-add').css('display', 'none');
                }
            });
        })
        </script>
    </body>

    </html>