<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/service.php');

if (MAINTENANCE === TRUE) {
    header('Location: /_EXEPTIONS_/maintenance.php');
    exit;
}

$BDfunc = new Me("");
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'eng';

if (isset($_SESSION['login'])) {
    header('Location: /mail');
    exit;
}

if ($lang != 'eng'  && $lang != 'pol' && $lang != 'rus') {
    $error = 'Wrong language';
    $lang = 'eng';
}

$arrayLang = parse_ini_file('LangLib/' . $lang . '.ini', true);
?>

<!DOCTYPE html>
<html>

<head>
    <?php
    require_once '_PARTS_/1headNotLogged.php';
    function head_title()
    {
        echo 'RoleGame';
    }
    ?>
</head>

<body>
    <div class="container_body">

        <div class="pseudo_header"></div>

        <?php require_once '_PARTS_/2headerNotLogged.php'; ?>

        <div class="feature">
            <div class="intro">
                <span class="title">«RoleGame»</span>
                <div class="description"><?php echo $arrayLang['Description']['Short-Description']; ?></div>
            </div>

            <div class="space"></div>

            <div class="informations">
                <span class="informations_menu"><?php echo $arrayLang['Description']['About']; ?></span>

                <div class="informations_information">
                    <div class="informations_information_title"><?php echo $arrayLang['Description']['Q1']; ?></div>

                    <div class="informations_information_content"><?php echo $arrayLang['Description']['A1']; ?></div>
                </div>

                <div class="informations_information">
                    <div class="informations_information_title"><?php echo $arrayLang['Description']['Q2']; ?></div>

                    <div class="informations_information_content"><?php echo $arrayLang['Description']['A2']; ?></div>
                </div>

                <div class="informations_information">
                    <div class="informations_information_title"><?php echo $arrayLang['Description']['Q3']; ?></div>

                    <div class="informations_information_content"><?php echo $arrayLang['Description']['A3']; ?></div>
                </div>

                <div class="informations_information">
                    <div class="informations_information_title"><?php echo $arrayLang['Description']['Q4']; ?></div>

                    <div class="informations_information_content"><?php echo $arrayLang['Description']['A4']; ?></div>
                </div>
            </div>
        </div>

        <div class="pseudo_footer"></div>

        <?php require_once '_PARTS_/3footerNotLogged.php'; ?>
    </div>
</body>

</html>