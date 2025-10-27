<?php

    require_once './DAO/MemberDAO.php';
    $errs = [];

    session_start();

    $id = $_SESSION['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pw = $_POST['password'];
        $nickname = $_POST['nickname'];

        if ($pw === '') {
            $errs[] = '新しいパスワードを入力してください';
        } else if ($pw === $id) {
            $errs[] = '学籍番号を入力しないでください';
        }

        if ($nickname === '') {
            $errs[] = 'ニックネームを入力して下さい';
        }


        if (empty($errs)) {
            $memberDAO = new MemberDAO();
            $memberDAO->member_update($pw, $nickname, $id);
            $_SESSION['member'] = $memberDAO->get_member($member_id, $pw);

            header('Location:index.php');
            exit;
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
    <link rel="stylesheet" href="./css/modal.css">
</head>
<body class="d-flex align-items-center py-4">
    <main class="form-signin w-100 m-auto border border-light rounded-3 position-relative">
        <form action="" method="post">
            <div class="text-center mb-4">
                <h2>新規登録</h2>
            </div>
            <div class="form-floating mb-1">
                <input type="password" name="password" id="pw" class="form-control" placeholder="新しいパスワード" required>
                <label for="pw">新しいパスワード</label>
            </div>
            <div class="form-floating">
                <input type="text" name="nickname" class="form-control" id="nick" placeholder="ニックネーム" required>
                <label for="nick">ニックネーム</label>
            </div>
            <div>
            <?php foreach($errs as $e) { ?>
                <p class="text-danger fw-bold"><?= $e ?></p>
            <?php } ?>
            </div>
            <button type="submit" class="mt-3 btn btn-primary w-100 py-2">登録</button>
        </form>
    </main>
</body>
</html>
