<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/service.php');

if (MAINTENANCE) {
    header('Location: ' . ADDRESS_M . '/_EXEPTIONS_/maintenance.php');
    exit;
}

$BDfunc = new Me("");
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'eng';

if (isset($_SESSION['login'])) {
    header('Location: ' . ADDRESS_M . '/1I');
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
        isset($_POST['password2']) && !empty($_POST['password2']) &&
        isset($_POST['firstName']) && !empty($_POST['firstName']) &&
        isset($_POST['lastName']) && !empty($_POST['lastName']) &&
        isset($_POST['gender']) && !empty($_POST['gender']) &&
        isset($_POST['day']) && !empty($_POST['day']) &&
        isset($_POST['month']) && !empty($_POST['month']) &&
        isset($_POST['year']) && !empty($_POST['year'])
    ) {
        $error = 0;

        $firstNameLetters = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
        for ($i = 0; $i < count($firstNameLetters); $i++) {
            $s = $firstNameLetters[$i];
            if (
                $s == 0 || $s == 1 || $s == 2 || $s == 3 || $s == 4 || $s == 5 || $s == 6 || $s == 7 || $s == 8 || $s == 9 ||
                $s == "!" || $s == "@" || $s == "#" || $s == "$" || $s == "%" || $s == "^" || $s == "&" || $s == "*" || $s == "(" ||
                $s == ")" || $s == "[" || $s == "]" || $s == "{" || $s == "}" || $s == ";" || $s == ":" || $s == "'" || $s == "\"" ||
                $s == "<" || $s == ">" || $s == "," || $s == "." || $s == "/" || $s == "?" || $s == "\\" || $s == "|" || $s == "-" ||
                $s == "_" || $s == "=" || $s == "+"
            ) {
                $error += 1;
            }
        }
        $lastNameLetters = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
        for ($i = 0; $i < count($lastNameLetters); $i++) {
            $s = $lastNameLetters[$i];
            if (
                $s == 0 || $s == 1 || $s == 2 || $s == 3 || $s == 4 || $s == 5 || $s == 6 || $s == 7 || $s == 8 || $s == 9 ||
                $s == "!" || $s == "@" || $s == "#" || $s == "$" || $s == "%" || $s == "^" || $s == "&" || $s == "*" || $s == "(" ||
                $s == ")" || $s == "[" || $s == "]" || $s == "{" || $s == "}" || $s == ";" || $s == ":" || $s == "'" || $s == "\"" ||
                $s == "<" || $s == ">" || $s == "," || $s == "." || $s == "/" || $s == "?" || $s == "\\" || $s == "|" || $s == "-" ||
                $s == "_" || $s == "=" || $s == "+"
            ) {
                $error += 1;
            }
        }

        $emailFree = $BDfunc->select('users', ['login'], ['login' => $_POST['login']]);
        $m =  count($emailFree);
        if ($m != 0) {
            $error += 1;
        } else {
            if (preg_match('/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/', $_POST['login']) === 0) {
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

        if ($_POST['day'] == 29) {
            if ($_POST['month'] == 2) {
                if (($_POST['year'] % 400 != 0) && ($_POST['year'] % 4 != 0 || $_POST['year'] % 100 == 0)) {
                    $error += 1;
                }
            }
        }
        if ($_POST['day'] == 30) {
            if ($_POST['month'] == 2) {
                $error += 1;
            }
        }
        if ($_POST['day'] == 31) {
            if ($_POST['month'] == 2 || $_POST['month'] == 4 || $_POST['month'] == 6 || $_POST['month'] == 9 || $_POST['month'] == 11) {
                $error += 1;
            }
        }

        if ($error == 0) {
            $salt = salt();
            $BDfunc->insert('users', [
                '_m_group' => 4,
                'login' => $_POST['login'],
                'password' => md5(md5($_POST['password1']) . $salt),
                'firstName' => $_POST['firstName'],
                'lastName' => $_POST['lastName'],
                'gender' => $_POST['gender'],
                'day' => $_POST['day'],
                'month' => $_POST['month'],
                'year' => $_POST['year'],
                'lang' => $lang,
                'date_register' => local2gm(time()),
                'salt' => $salt,
                'active_hex' => md5($salt),
                'is_activated' => 0
            ]);
            $_key_reg_ = true;
            $_key_act_ = false;

            $url = ADDRESS_M . '/log/?key=' . md5($salt) . "&lang=" . $lang;
            $title = 'Registration at http://rolegame.com';
            $message = 'To activate your account click'  . " <a href=\"" . $url . "\">" . 'here' . "</a>.";
            sendMessageMail($_POST['login'], EMAIL, $title, $message);
        } else {
            $_key_reg_ = false;
            $_key_act_ = false;
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
                echo '        You have successfully registered. Check your email to activate your account. Message can be in spam. Check it!';
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
                    <!-- <div class="input-group mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend3"><?php echo $arrayLang['Creating']['First-Name']; ?></span>
                            </div>

                            <input type="text" name="firstName" value="" placeholder="" autocomplete="off" required class="form-control">
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend3"><?php echo $arrayLang['Creating']['Last-Name']; ?></span>
                            </div>

                            <input type="text" name="lastName" value="" placeholder="" autocomplete="off" required class="form-control">
                        </div>
                    </div> -->

                    <div class="input-group mb-3">
                        <input type="text" name="firstName" value="" placeholder="<?php echo $arrayLang['Creating']['First-Name']; ?>" autocomplete="off" class="form-control">

                        <input type="text" name="lastName" value="" placeholder="<?php echo $arrayLang['Creating']['Last-Name']; ?>" autocomplete="off" class="form-control">

                        <div class="valid-feedback" id="invalidName"></div>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend3">E-mail</span>
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

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <?php echo $arrayLang['Creating']['Gender']; ?>
                            </div>
                        </div>

                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" name="gender" value="male" required id="male">
                            </div>
                        </div>

                        <label class="form-control" for="male"><?php echo $arrayLang['Creating']['Male']; ?></label>

                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" name="gender" value="female" required id="female" checked>
                            </div>
                        </div>

                        <label class="form-control" for="female"><?php echo $arrayLang['Creating']['Female']; ?></label>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <?php echo $arrayLang['Creating']['Date-Of-Birth']; ?>
                            </div>
                        </div>

                        <select name="day" class="custom-select" id="day" required>
                            <option label="<?php echo $arrayLang['Creating']['Day']; ?>"></option>
                            <?php
                            $this_day = (int) getdate(time())['mday'];
                            for ($i = 1; $i <= 31; $i++) {
                                if ($i < 10) {
                                    if ($this_day == $i) echo "<option value=\"0$i\" selected>0$i</option>";
                                    else echo "<option value=\"0$i\">0$i</option>";
                                } else {
                                    if ($this_day == $i) echo "<option value=\"$i\" selected>$i</option>";
                                    else echo "<option value=\"$i\">$i</option>";
                                }
                            }
                            ?>
                        </select>

                        <select name="month" class="custom-select" id="month" required>
                            <option label="<?php echo $arrayLang['Creating']['Month']; ?>"></option>
                            <?php
                            $this_month = (int) getdate(time())['mon'];
                            ?>

                            <option value="01" <?php if ($this_month == 1) echo "selected"; ?>>
                                <?php echo $arrayLang['Creating']['January']; ?>
                            </option>

                            <option value="02" <?php if ($this_month == 2) echo "selected"; ?>>
                                <?php echo $arrayLang['Creating']['February']; ?>
                            </option>

                            <option value="03" <?php if ($this_month == 3) echo "selected"; ?>>
                                <?php echo $arrayLang['Creating']['March']; ?>
                            </option>

                            <option value="04" <?php if ($this_month == 4) echo "selected"; ?>>
                                <?php echo $arrayLang['Creating']['April']; ?>
                            </option>

                            <option value="05" <?php if ($this_month == 5) echo "selected"; ?>>
                                <?php echo $arrayLang['Creating']['May']; ?>
                            </option>

                            <option value="06" <?php if ($this_month == 6) echo "selected"; ?>>
                                <?php echo $arrayLang['Creating']['June']; ?>
                            </option>

                            <option value="07" <?php if ($this_month == 7) echo "selected"; ?>>
                                <?php echo $arrayLang['Creating']['July']; ?>
                            </option>

                            <option value="08" <?php if ($this_month == 8) echo "selected"; ?>>
                                <?php echo $arrayLang['Creating']['August']; ?>
                            </option>

                            <option value="09" <?php if ($this_month == 9) echo "selected"; ?>>
                                <?php echo $arrayLang['Creating']['September']; ?>
                            </option>

                            <option value="10" <?php if ($this_month == 10) echo "selected"; ?>>
                                <?php echo $arrayLang['Creating']['October']; ?>
                            </option>

                            <option value="11" <?php if ($this_month == 11) echo "selected"; ?>>
                                <?php echo $arrayLang['Creating']['November']; ?>
                            </option>

                            <option value="12" <?php if ($this_month == 12) echo "selected"; ?>>
                                <?php echo $arrayLang['Creating']['December']; ?>
                            </option>
                        </select>

                        <select name="year" class="custom-select" id="year" required>
                            <option label="<?php echo $arrayLang['Creating']['Year']; ?>"></option>
                            <?php
                            $this_year = (int) getdate(time())['year'];
                            $this_year -= 16;
                            for ($i = 2019; $i >= 1900; $i--) {
                                if ($this_year == $i) echo "<option value=\"$i\" selected>$i</option>";
                                else echo "<option value=\"$i\">$i</option>";
                            }
                            ?>
                        </select>

                        <div class="valid-feedback" id="wrongDate"></div>
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

        <?php require_once '../_PARTS_/3footerNotLogged.php'; ?>
    </div>
</body>

</html>