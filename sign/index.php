<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/service.php');

if (MAINTENANCE) {
    header('Location: /_EXEPTIONS_/maintenance.php');
    exit;
}

$BDfunc = new Me("");
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'eng';

if (isset($_SESSION['login'])) {
    header('Location: /mail');
    exit;
}

if ($lang != 'eng' &&  $lang != 'pol' && $lang != 'rus') {
    $error = 'Wrong language';
    $lang = 'eng';
}

if (isset($_POST['submit'])) {
    if (
        isset($_POST['login']) && !empty($_POST['login']) &&
        isset($_POST['password1']) && !empty($_POST['password1']) &&
        isset($_POST['password2']) && !empty($_POST['password2'])
    ) {
        $error = 0;

        $emailFree = $BDfunc->select('users', ['username'], ['username' => $_POST['login']]);
        $m = count($emailFree);
        if ($m != 0) {
            $error += 1;
        } else {
            if (preg_match('/^([A-Za-z0-9_\-\.])+$/', $_POST['login']) === 0) {
                $error += 1;
            }
        }

        if ($_POST['password1'] == $_POST['password2']) {
            if (strlen($_POST['password1']) < 3) {
                $error += 1;
            }
        } else {
            $error += 1;
        }

        if ($error == 0) {
            $salt = salt();
            $BDfunc->insert('users', [
                'login' => $_POST['login'],
                'password' => md5(md5($_POST['password1']) . $salt),
                'salt' => $salt,
                'lang' => $lang,
                'date_register' => time()
            ]);
            $_key_reg_ = true;
        } else {
            $_key_reg_ = false;
        }
    }
}

global $arrayLang;
$arrayLang = parse_ini_file('LangLib/' . $lang . '.ini', true);
?>

<!DOCTYPE html>
<html>

<head>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/1headNotLogged.php');

    function head_title()
    {
        global $arrayLang;
        echo $arrayLang['Title']['_main_'] . ' | RoleGame';
    }
    ?>
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
            if ($_key_reg_ === true) {
                echo '<div class="space"></div>';
                echo '<div class="font-size-normal">';
                echo '    <div class="alert alert-light">';
                echo '        You have successfully registered.';
                echo '    </div>';
                echo '</div>';
            } elseif ($_key_reg_ === false) {
                echo '<div class="space"></div>';
                echo '<div class="font-size-normal">';
                echo '    <div class="alert alert-light">';
                echo '        <h4 class=\"alert-heading\">Oooops!</h4>';
                echo "      <p>You can not register because of some errors. Make sure that your data is valid and try again.</p>";
                echo '    </div>';
                echo '</div>';
            }
            ?>

            <div class="log_in">
                <form action="" method="POST">
                    <div class="input-group mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend3">Username</span>
                            </div>

                            <input type="text" name="login" value="" placeholder="" autocomplete="new-password" class="form-control">
                        </div>

                        <div class="valid-feedback" id="busyEmail"></div>

                        <div class="valid-feedback" id="incorrectEmail"></div>
                    </div>

                    <div class="input-group mb-3" id="show_hide_password">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend3"><?php echo $arrayLang['Creating']['Pass']; ?></span>
                            </div>

                            <input type="password" name="password1" value="" placeholder="" autocomplete="new-password" class="form-control">

                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3" id="show_hide_repeat_password">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend3"><?php echo $arrayLang['Creating']['Repeat']; ?></span>
                            </div>

                            <input type="password" name="password2" value="" placeholder="" autocomplete="new-password" class="form-control">

                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>

                        <div class="valid-feedback" id="wrongPassword"></div>
                    </div>

                    <div class="progress mb-3" style="height: 10px;">
                        <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="howComplexIsPassword"></div>
                    </div>

                    <div class="submition-container">
                        <div class="submition">
                            <input type="submit" name="submit" value="" class="display-none" id="origin-submit">

                            <button type="button" class="btn btn-light submit" id="log-pseudo-submit"><?php echo $arrayLang['Submition']['Log-In']; ?></button>

                            <div class="my_link cancel" data-href="/?lang=<?php echo $lang; ?>">
                                <button type="button" class="btn my_btn"><?php echo $arrayLang['Submition']['Cancel']; ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="pseudo_footer"></div>

        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/3footerNotLogged.php'); ?>
    </div>
</body>

</html>