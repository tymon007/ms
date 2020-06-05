<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/server.php');

if (!isset($_SESSION['login'])) {
    $_SESSION = [];
    header('Location: /log/?notLogin=true&thisPage=/menu/');
    exit;
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/langPLUSme.php');
?>
<!DOCTYPE html>
<html>

<head>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/1head.php');

    function head_title()
    {
        echo 'Other activities';
    }
    ?>
</head>

<body>
    <div class='container_body'>
        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/2header.php'); ?>

        <div class='feature'>
            <div class="my_link" data-href="">News</div>

            <div class="my_link" data-href="/settings">Settings</div>

            <div class="my_link" data-href="">Rules</div>

            <div class="my_link" data-href="">F.A.Q.</div>

            <div class="my_link" data-href="">Contact with developers</div>

            <div class="my_link" data-href="">Credits</div>

            <div class="my_link" data-href="">For future</div>

            <div class="my_link" data-href="?exit=true">Exit</div>
        </div>

        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/3footer.php'); ?>
    </div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/includeAutosize.php'); ?>
</body>

</html>