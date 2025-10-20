<?php
    $user_agent = $_SERVER['HTTP_USER_AGENT'];


    require_once '';
?>

<!DOCTYPE html>
<html_entity_decode>
<head>
    <meta charset="UTF-8">
    <title>詳細検索</title>
</head>
<body>
    <?php if (!preg_match('/Mobile|Android|iPhone/', $user_agent)) {
        include "header.php";
    } else {
        include "footer.php";
    } ?>
    

</body>
</html>