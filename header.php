<head>
    <link rel="stylesheet" href="./css/nav.css">
    <script src="https://kit.fontawesome.com/a3491c9dc9.js" crossorigin="anonymous"></script>
</head>

<header class="navbar navbar-expand-xl fixed-top" style="background-color: #ced4da;">
    <div class="container-fluid d-flex">
        <a href="./" class="navbar-brand">
            <img src="./images/JECエリアサーチャー1.svg" alt="ロゴ" width="300">
        </a>
        <form action="./search_result.php" method="get" class="p-2 search-form" role="search">
            <label for="Search-input" id="search-label"><i class="fa-solid fa-magnifying-glass"></i></label>
            <input type="search" name="keyword" placeholder="検索" aria-labelledby="search-label" id="Search-input" class="me-2 search-input" 
            <?php if (isset($keyword)) { ?>value="<?= $keyword ?>" <?php } ?>>
            <button type="sumbit" class="btn btn-outline-success">検索</button>
        </form>
        <div>
            <ul class="my-auto navi">
                <li class="mb-2 mx-3 nav-item d-flex align-items-center">
                    <a class="px-2 text-secondary dropdown-item" href="./" title="ホーム">
                        <i class="fa-solid fa-house fa-xl"></i>
                    </a>
                </li>
                <li class="mb-2 mx-3 nav-item d-flex align-items-center">
                    <a class="px-2 text-secondary dropdown-item" href="./roulette.php" title="ルーレット">
                        <i class="fa-solid fa-dharmachakra fa-xl"></i>
                    </a>
                </li>
                <li class="mb-2 mx-3 nav-item d-flex align-items-center">
                    <a class="px-2 text-secondary dropdown-item" href="#" title="詳細検索">
                        <i class="fa-solid fa-magnifying-glass-plus fa-xl"></i>
                    </a>
                </li>
                <li class="mb-2 mx-3 nav-item d-flex align-items-center">
                    <a class="px-2 text-secondary dropdown-item" href="#" title="パスワード変更">
                        <i class="fa-solid fa-key fa-xl"></i>
                    </a>
                </li>
            </ul>
        </div>

        <div class="btn-group toggle">
            <button type="button" class="btn-config dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-bars fa-2x"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li class="mb-2 mx-3 nav-item d-flex align-items-center">
                    <a class="px-2 text-secondary dropdown-item" href="./">
                        <i class="fa-solid fa-house fa-xl"></i>
                        <span class="fs-4 ms-2">ホーム</span>
                    </a>
                </li>
                <li class="mb-2 mx-3 nav-item d-flex align-items-center">
                    <a class="px-2 text-secondary dropdown-item" href="./roulette.php">
                        <i class="fa-solid fa-dharmachakra fa-xl"></i>
                        <span class="fs-4 ms-2">ルーレット</span>
                    </a>
                </li>
                <li class="mb-2 mx-3 nav-item d-flex align-items-center">
                    <a class="px-2 text-secondary dropdown-item" href="#">
                        <i class="fa-solid fa-magnifying-glass-plus fa-xl"></i>
                        <span class="fs-4 ms-2">詳細検索</span>
                    </a>
                </li>
                <li class="mb-2 mx-3 nav-item d-flex align-items-center">
                    <a class="px-2 text-secondary dropdown-item" href="#">
                        <i class="fa-solid fa-key fa-xl"></i>
                        <span class="fs-4 ms-2">パスワード変更</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>