<?php
require_once '../_PARTS_/server.php';

if ($detect->isMobile()) {
    header('Location: ' . ADDRES_M . '6Settings/');
    exit;
}

if (!isset($_SESSION['login'])) {
    $_SESSION = [];
    header('Location: ' . ADDRES . '?notLogin=true&thisPage=/6Settings/');
    exit;
}

require_once '../_PARTS_/langPLUSme.php';
?>
<!DOCTYPE html>
<html>

<head>
    <?php
    require_once '../_PARTS_/head.php';
    function head_title()
    {
        global $arrayLang;
        echo 'Уряяяяяяяяя';
    }
    ?>
</head>

<body>
    <?php
    $current2 = true;
    require_once '../_PARTS_/header.php';
    ?>

    <div class="feature">
        <div class="featureLeft"></div>
        <div class="featureCenter">
            Successfully edited password!!!
        </div>
        <div class="featureRight"></div>
    </div>

    <?php require_once '../_PARTS_/footer.php'; ?>
</body>

</html>