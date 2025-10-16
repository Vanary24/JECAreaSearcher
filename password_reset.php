<?php
    require_once './DAO/MemberDAO.php';
    
    session_start();

    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pw = $_POST['password'];
        $pw_c = $_POST['password_c'];

        if ($pw === '') {
            $err = '新しいパスワードを入力してください';

            if ($pw_c === '') {
                $err = '新しいパスワードを再入力してください';

                if ($pw !== $pw_c) {
                    $err = '新しいパスワードと不一致です';
                }
            }
        }

        if (empty($err)) {
            $msg = 'パスワード再設定しました';
            $memberDAO = new MemberDAO();
            $memberDAO->update_password($pw, $id);
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>パスワード再設定</title>
    <link rel="stylesheet" href="./helper/bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/sign-in.css">
    <link rel="stylesheet" href="./css/modal.css">
</head>
<body class="d-flex align-items-center py-4">
    <main class="form-signin w-100 m-auto border border-light rounded-3 position-relative">
        <form action="" method="post">
            <div class="text-center mb-4">
                <h2>パスワード再設定</h2>
            </div>
            <div class="form-floating mb-1">
                <input type="password" name="password" id="pw" class="form-control" placeholder="新しいパスワード" required>
                <label for="pw">新しいパスワード</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password_c" class="form-control" id="pw_c" placeholder="新しいパスワード再入力" required>
                <label for="pw_c">再入力</label>
            </div>
            <div>
            <?php if(isset($err)) { ?>
                <span class="text-danger fw-bold"><?= $err ?></span>
            <?php } ?>
            </div>
            <button type="submit" class="mt-3 btn btn-primary w-100 py-2">登録</button>
        </form>
    </main>
    
    <?php if (isset($msg)) { ?>
        <div class="Modal m-auto border border-light rounded-3" id="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><?= $msg ?></h3>
                </div>
            </div>
        </div>
    <?php } ?>

    <script>
        setTimeout(() => {
                let modal = document.getElementById('modal');
                modal.classList.add("fade");
                window.location.href = './login.php';
            }, 3000);
    </script>
</body>
</html>
