<?php
header("Location: /_EXEPTIONS_/developing.html");
exit;
require_once '../../func/detect_mobile.php';
$detect = new Mobile_Detect;

if ($detect->isMobile()) {
    header('Location: /m/1I/');
    exit;
}
session_start();
define('BEZ_KEY', true);
include '../config.php';
include '../bd/bd.php';
include '../func/funct.php';
$login = $_SESSION['login'];
if (isset($_GET['exit']) == true) {
    session_destroy();
    $sql = "UPDATE `users` SET `lastday` = " . date('d') . ", `lastmonth` = " . date('m') . ", `lastyear` = " . date('Y') . ", `lasthour` = " . date('H') . ", `lastminute` = " . date('i') . ", `lastsecund` = " . date('s') . " WHERE login = '$login'";
    $stmt = $db->exec($sql);
    header('Location:' . BEZ_HOST);
    exit;
} else {
    $sql = "UPDATE `users` SET `lastday` = 0, `lastmonth` = 0, `lastyear` = 0, `lasthour` = 0, `lastminute` = 0, `lastsecund` = 0 WHERE login = '$login'";
    $stmt = $db->exec($sql);
}
if (!isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
    session_destroy();
    $sql = "UPDATE `users` SET `lastday` = " . date('d') . ", `lastmonth` = " . date('m') . ", `lastyear` = " . date('Y') . ", `lasthour` = " . date('H') . ", `lastminute` = " . date('i') . ", `lastsecund` = " . date('s') . " WHERE login = '$login'";
    $stmt = $db->exec($sql);
    header('Location:' . BEZ_HOST . '?notLogin=true#log');
    exit;
} else {
    $sql = "UPDATE `users` SET `lastday` = 0, `lastmonth` = 0, `lastyear` = 0, `lasthour` = 0, `lastminute` = 0, `lastsecund` = 0 WHERE login = '$login'";
    $stmt = $db->exec($sql);
}
$sql = "SELECT * FROM `users` WHERE `login` = '" . $_SESSION['login'] . "'";
$stmt = $db->prepare($sql);
$stmt->execute();
$me = $stmt->fetchAll(PDO::FETCH_ASSOC);
$lang = $me[0]['lang'];
$lang = 'libraryOfLanguage/' . $lang;
$array = parse_ini_file($lang . ".ini");
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>
            <?php echo $array['My-Page'] ?>
        </title>
        <link rel="icon" type="images/png" href="/img/Logo2.png">
        <link rel="stylesheet" type="text/css" href="/css/mainStyle.css" charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css" charset="UTF-8">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="/chat/chat.js"></script>
    </head>

    <body>
        <div class="container">
            <header>
                <div class="headerLeft">
                    <a href="">
                        <span>RoleGame</span>
                    </a>
                </div>
                <div class="headerRight">
                    <div class="clearfix">
                        <ul class="menus clearfix">
                            <li>
                                <a href="/1I/index.php">
                                    <button class="main">
                                        <?= $array['I']; ?></button>
                                </a>
                            </li>
                            <li>
                                <a href="/2Relation/index.php">
                                    <button class="main">
                                        <?= $array['Relation']; ?></button>
                                </a>
                            </li>
                            <li>
                                <a href="/3Worlds/index.php">
                                    <button class="main">
                                        <?= $array['Worlds']; ?></button>
                                </a>
                                <ul class="sub-menus">
                                    <?php
                                    $sql = 'SELECT `name`, `id` FROM `worlds` WHERE `bossID` = ' . $me[0]['id'];
                                    $stmt = $db->prepare($sql);
                                    $stmt->execute();
                                    $listWorld = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    for ($i = 0; $i < count($listWorld); $i++) {
                                        echo '<li>';
                                        echo '<a href="/3Worlds/roleWorld/index.php?id=' . $listWorld[$i]['id'] . '">' . $listWorld[$i]['name'] . '</a>';
                                        echo '</li>';
                                    }
                                    ?>
                                </ul>
                            </li>
                            <li class="sub-menus-link">
                                <a href="/4Heroes/index.php">
                                    <button class="main">
                                        <?= $array['Heroes']; ?></button>
                                </a>
                            </li>
                            <li class="sub-menus-link">
                                <a href="/5Other/">
                                    <button class="main">
                                        <?= $array['Other']; ?></button>
                                </a>
                                <ul class="sub-menus">
                                    <li>
                                        <a href="/5Other/News/">
                                            <?= $array['News']; ?></a>
                                    </li>
                                    <li>
                                        <a href="/5Other/AnimeAndManga/">
                                            <?= $array['Anime-And-Manga']; ?></a>
                                    </li>
                                    <li>
                                        <a href="/5Other/Rules/">
                                            <?= $array['Rules']; ?></a>
                                    </li>
                                    <li>
                                        <a href="/5Other/FAQ/">F.A.Q.</a>
                                    </li>
                                    <li>
                                        <a href="/5Other/Contact/">
                                            <?= $array['Contact-With-Developers']; ?></a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $_SERVER['PHP_SELF'] . '?exit=true'; ?>">
                                            <?= $array['Exit']; ?></a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="/6Settings/index.php">
                                    <img src="/img/settings.png" class="settings" alt="<?= $array['Settings']; ?>" title="<?= $array['Settings']; ?>">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>
        </div>

        <div class="container-for-users">
            <div class="users">
                <form method="POST" class="search-block">
                    <input type="text" name="search-user" value="" placeholder="<?= $array['Find-Users']; ?>" autocomplete="off" class="search">
                    <input type="submit" name="search" value="<?= $array['Find']; ?>" class="search-submit">
                </form>
            </div>
        </div>

        <div class="container-for-chat">
            <div class="chat">
                <textarea placeholder="<?= $array['Chat']; ?>" name="text-chat" id="text-chat"></textarea>
                <button id="chat-submit" type="submit" class="submit">Send</button>
                <input type="hidden" data-id="<?php echo $me[0]['firstName'] ?>" id="chatHidden">
                <div class="messageChat" id="message"></div>
            </div>
        </div>

        <div class="feature">
            <div>
                <div class="featureLeft">
                    <?php echo $me[0]['firstName']; ?>
                    <?php echo $me[0]['lastName'];
                    ?>
                    <br>
                    <?php 
                    $day = $me[0]['day'];
                    if ($day < 10) $day = '0' . $day;
                    $month = $me[0]['month'];
                    if ($month < 10) $month = '0' . $month;
                    ?>
                    <?php echo $day; ?>.<?php echo $month; ?>.<?php echo $me[0]['year']; ?>
                    <br>
                    <?php if ($me[0]['gender'] == 'male') echo $array['Male'];
                    else echo $array['Female']; ?>
                </div>
                <div class="photo">
                    <div id="photo" style="background-image: url('/userimg/users/<?php echo $me[0]['image'] ?>');"></div>
                </div>
                <div class="featureRight"></div>
            </div>
        </div>

        <div class="footer"></div>

    </body>

</html>