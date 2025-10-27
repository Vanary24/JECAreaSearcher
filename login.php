<?php
$errs = [];

require_once './DAO/MemberDAO.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $password = $_POST['password'];

    if ($id === '') {
        $errs[] = '学籍番号を入力して下さい';
    }

    

    if ($password === '') {
        $errs[] = 'パスワードを入力して下さい';
    }

    if (empty($errs)) {
        $memberDAO = new MemberDAO();
        if ($memberDAO->member_password_exists($password) && $memberDAO->get_member($id, $password) !== null) {
            $_SESSION['id'] = $id;
            header('Location:register.php');
            exit;
        } else {
            $member = $memberDAO->get_member($id, $password);

            if ($member !== false) {
                session_regenerate_id(true);
                $_SESSION['member'] = $member;
                header('Location:index.php');
                exit;
            } else {
                $errs[] = '学籍番号またはパスワードに誤りがあります。';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="./helper/bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/sign-in.css">
    <script src="https://kit.fontawesome.com/a3491c9dc9.js" crossorigin="anonymous"></script>
    <style>
        .form-link {
            text-underline-offset: 0.25em !important;
            text-decoration: none;
        }

        .form-link span {
            font-weight: bold;
            color: black;

        }

        .form-link svg {
            color: red;
            position: relative;
            transition: .3s;

        }

        .show {
            transform: translateX(20px);
        }
    </style>
</head>

<body class="d-flex align-items-center py-4">
    <main class="form-signin w-100 m-auto border border-light rounded-3 position-relative">
        <div class="position-absolute start-0 translate-middle-y" style="bottom: -100px;">
            <img src="./images/JECエリアサーチャー.svg" alt="ロゴ">
        </div>
        <form action="" method="post">
            <h3 class="fw-bold mb-3">ログイン</h3>
            <div class="form-floating mb-1">
                <input type="text" name="id" id="idNumber" class="form-control" placeholder="学籍番号"
                    <?php if (!empty($id)) { ?>
                    value="<?= $id ?>"
                    <?php } ?> required autofocus>
                <label for="idNumber">学籍番号</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="password" placeholder="パスワード" required>
                <label for="password">パスワード</label>
            </div>
            <div>
                <?php foreach ($errs as $e) { ?>
                    <p class="text-danger fw-bold"><?= $e ?></p>
                <?php } ?>
            </div>
            <button type="submit" class="mt-3 btn btn-primary w-100 py-2">ログイン</button>
            <div class="mt-3 text-center">
                <a href="./email_send.php" class="form-link" id="link">
                    <span class="me-2">パスワードを忘れた方</span>
                    <svg id="slide" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z" />
                    </svg>
                </a>
            </div>
        </form>
    </main>

    <script>
        const a = document.getElementById('link');
        const img = document.getElementById('slide');

        a.addEventListener('mouseenter', () => {
            img.classList.add('show');
        });

        a.addEventListener('mouseleave', () => {
            img.classList.remove('show');
        })
    </script>
</body>

</html>