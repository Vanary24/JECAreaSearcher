<?php
    $user_agent = $_SERVER['HTTP_USER_AGENT'];


    require_once '';
?>

<!DOCTYPE html>
<html_entity_decode>
<head>
    <meta charset="UTF-8">
    <title>詳細検索</title>
      <link rel="stylesheet" href="./helper/bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/index.css">
    <script src="./helper/bootstrap-5.0.0-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php if (!preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "header.php";
    } ?>
       <form action method="get">
        <div class="container-fulid mt-3">
             <div class="d-flex justify-content-center align-items-center ">
                 <div class="text-center">
                            <h3 class="my-2">詳細検索</h3>
                 </div>
                  <div class="row g-3">
                            <div class="col-12">
                                <label for="keyword" class="form-label">キーワード入力</label>
                                <input type="text" name="store_keyword" id="keyword" class="form-control" placeholder="お店の名前">
                            </div>
                             <div class="col">
                                  <label class="form-label">
                                    ハッシュタグ入力（最大３つまで）
                                    <button type="button" name="tag" class="tag-add" id="add">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                        </svg>
                                    </button>
                                  </label>
                                     <div class="d-flex align-items-center" id="tag">
                                    <input type="text" name="store_tag[]" class="form-control mx-2">
                                     </div>
                            </div>
                            <div class="col-12">
                                <label for="goukann" class="form-label">号館入力</label>
                            </div>
                  </div>
                 
             </div>
        </div>
       </form>
       
    


    
    <?php if (preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "footer.php";
    } ?>
</body>
</html>