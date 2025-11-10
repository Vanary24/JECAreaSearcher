<?php
require_once 'DAO/adminDAO.php';

$user_agent = $_SERVER['HTTP_USER_AGENT'];

$adminDAO = new AdminDAO();
$tmp_list = $adminDAO->get_tmp_data();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>管理者画面</title>
    <link rel="stylesheet" href="./helper/bootstrap-5.0.0-dist/css/bootstrap.min.css">
    <script src="./helper/bootstrap-5.0.0-dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style="padding-top: 100px;">
    <?php if (!preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "header.php";
    } ?>
    
    
    <?php if (preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "footer.php";
    } ?>
</body>

</html>