<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/server.php');

if (!isset($_SESSION['login'])) {
    $_SESSION = [];
    header('Location: /log/?notLogin=true&thisPage=/settings/');
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
        echo 'Settings';
    }
    ?>
</head>

<body>
    <div class='container_body'>
        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/2header.php'); ?>

        <div class='feature'>
            <?php?>
            <form action="<?php echo $link ?>?" method="POST">
                <div class="input-group mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text logElement" id="inputGroupPrepend3">Username</span>
                        </div>

                        <input type="text" name="login" value="" placeholder="" autocomplete="off" required class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
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
                        <input type="submit" name="submit" value="Edit" class="btn btn-light submit">

                        <div class="my_link cancel" data-href="/me">
                            <button type="button" class="btn my_btn">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/3footer.php'); ?>
    </div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/includeAutosize.php'); ?>
</body>

</html>