<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/service.php');

if (isset($_SESSION['login'])) {
    header('Location: /mail');
    exit;
}

if (isset($_POST['submit']) && !empty($_POST['submit'])) {
    $user = $BDfunc->select('users', ['password', 'salt'], ['login' => $_POST['login']]);
    if (count($user) != 0) {
        if (md5(md5($_POST['password']) . $user[0]['salt']) == $user[0]['password']) {
            $_SESSION['login'] = $_POST['login'];
            if ($_GET['thispage'] !== NULL) header('Location: /' . ADDRESS_M . $_GET['thispage']);
            else header('Location: ' . ADDRESS_M . '/me');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?php head_title(); ?></title>
    
    <link rel="icon" type="images/ico" href="<?php echo ADDRESS_DATA; ?>/img/fav.ico" sizes="16x16">
    <link rel="stylesheet" type="text/css" href="/_FRAMEWORKS_/bootstrap/css/bootstrap.min.css" charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/_MAIN_/style.css" charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css" charset="UTF-8">
    
    <script src="/_FRAMEWORKS_/jquery/dist/jquery.js"></script>
    <script src="/_FRAMEWORKS_/popper.js/dist/umd/popper.js"></script>
    <script src="/_FRAMEWORKS_/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/b9bdbd120a.js"></script>
    <script src="/_MAIN_/script.js"></script>
    <script src="script.js"></script>
</head>

<body>
    <div class="container_body">

        <div class="pseudo_header"></div>

        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/2headerNotLogged.php'); ?>

        <div class="feature">
            <div class="intro">
                <span class="title">«RoleGame»</span>
                <div class="description"><?php echo $arrayLang['Description']['Short-Description']; ?></div>
            </div>

            <div class="space"></div>

            <div class="content-title">
                <?php echo $arrayLang['Description']['_title_']; ?>
            </div>

            <?php
            if (isset($_GET['key'])) {
                $myLogin = $BDfunc->select('users', ['login'], ['active_hex' => $_GET['key']]);
                if (count($myLogin) == 0) {
                    echo '<div class="space"></div>';
                    echo '<div class="font-size-normal">';
                    echo '    <div class="alert alert-danger">';
                    echo '        Activation key is not correct!';
                    echo '    </div>';
                    echo '</div>';
                } else {
                    $BDfunc->update('users', ['active_hex' => '', 'is_activated' => 1], ['login' => $myLogin[0]['login']]);
                    $title = 'Your account at http://rolegame.com has been successfully activated.';
                    $message = 'Congratulations, your account at http://rolegame.com has been successfully activated.';
                    sendMessageMail($myLogin[0]['_m_login'], EMAIL, $title, $message);
                    echo '<div class="space"></div>';
                    echo '<div class="font-size-normal">';
                    echo '    <div class="alert alert-light">';
                    echo '        Your account has been successfully activated. Log in, please.';
                    echo '    </div>';
                    echo '</div>';
                }
            }
            ?>

            <?php
            $link = "";
            if (isset($_GET['notLogin']) && $_GET['notLogin'] == true) {
                $link = $_SERVER['PHP_SELF'] . '?lang=' . $lang . '&thispage=' . $_GET['thisPage'];
                echo '<div class="space"></div>';
                echo '<div class="font-size-normal">';
                echo '    <div class="alert alert-wrong">';
                echo '        You are not logged in! Log in!';
                echo '    </div>';
                echo '</div>';
            }
            ?>

            <?php
            if (isset($_POST['submit']) && !empty($_POST['submit'])) {
                $user = $BDfunc->select('users', ['password', 'salt'], ['login' => $_POST['login']]);
                if (count($user) == 0) {
                    echo '<div class="space"></div>';
                    echo '<div class="font-size-normal">';
                    echo '    <div class="alert alert-wrong">';
                    echo '        Account with login <strong>' . $_POST['email'] . '</strong> is not activated or not registered!';
                    echo '    </div>';
                    echo '</div>';
                } else {
                    echo '<div class="space"></div>';
                    echo '<div class="font-size-normal">';
                    echo '    <div class="alert alert-wrong">';
                    echo '        Wrong password!';
                    echo '    </div>';
                    echo '</div>';
                }
            }
            ?>

            <div class="log_in">
                <form action="<?php echo $link ?>?" method="POST">
                    <div class="input-group mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text logElement" id="inputGroupPrepend3">E-mail</span>
                            </div>

                            <input type="email" name="login" value="" placeholder="" autocomplete="off" required class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text logElement" id="inputGroupPrepend3"><?php echo $arrayLang['Login']['Pass']; ?></span>
                            </div>

                            <input type="password" name="password" value="" placeholder="" autocomplete="off" required class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                        </div>
                    </div>

                    <div class="submition-container">
                        <div class="submition">
                            <input type="submit" name="submit" value="<?php echo $arrayLang['Submition']['Log-In']; ?>" class="btn btn-light submit">

                            <div class="my_link cancel" data-href="/?lang=<?php echo $lang; ?>">
                                <button type="button" class="btn my_btn"><?php echo $arrayLang['Submition']['Cancel']; ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="pseudo_footer"></div>

        <?php require_once '../_PARTS_/3footerNotLogged.php'; ?>
    </div>
</body>

</html>