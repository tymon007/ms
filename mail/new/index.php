<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/server.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/langPLUSme.php');
?>
<!DOCTYPE html>
<html>

<head>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/1head.php');

    function head_title()
    {
        echo 'Messages';
    }
    ?>
</head>

<body>
    <div class='container_body' id="stepOne">
        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/2header.php'); ?>

        <div class='feature'>
            <div class="cont_search_user">
                <input type="search" placeholder="Search" class="search_user">
                <div class="search_icon">
                    <img src="/img/search.svg" width="40px">
                </div>
            </div>

            <div class="users">
                <?php
                $users = $me->select('users', ['login', 'id']);
                for ($i = 0; $i < count($users); $i++) {
                    $image = $users[$i]['image'];
                    if ($image === NULL) {
                        /*if ($users[$i]['gender'] == 'male')*/ $image = '/img/user_male.svg';
                        // elseif ($users[$i]['gender'] == 'female') $image = '/img/user_female.svg';
                    } else {
                        $image = '/userimg/users/' . $image;
                    }
                    $names = $users[$i]['firstName'] . ' ' . $users[$i]['lastName'];
                    $names = $users[$i]['login'];
                    echo '<div class="user" data-user-id="' . $users[$i]['id'] . '" data-is-selected="false">';
                    echo '    <div class="image" style="background-image: url(\'' . $image . '\')"></div>';
                    echo '    <div class="name">' . $names . '</div>';
                    echo '</div>';
                }
                ?>
            </div>

            <div class="nextStepToCreateConversation" style="background-image: url('<?php echo '/img/next.svg'; ?>')"></div>
        </div>

        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/3footer.php'); ?>
    </div>

    <div class='container_body' id="stepTwo">
        <div class="header">
            <div class="logo">
                <div class="backToStepOne">
                    <img src="/img/back.svg" width="40px">
                </div>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class='feature'>
            <div class="cont4creatingConv">
                <input type="file" name="image4conv" class="display-none" id="image4conv" accept=".jpg, .jpeg, .png">

                <div class="imageofConversation" style="background-image: url('http://data.rpg.com/img/picture.svg')"></div>

                <div class="mb-3">
                    <input type="text" name="login" placeholder="Enter name of conversation" value="" autocomplete="off" class="titleOfConversation form-control" maxlength="128" required>

                    <div class="valid-feedback" id="invalidConvName"></div>
                </div>

                <div class="submition-container">
                    <div class="submition">
                        <button type="button" class="btn btn-light submit" id="create-pseudo-submit">Create</button>

                        <div class="my_link cancel" data-href="/mail/">
                            <button type="button" class="btn my_btn">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/3footer.php'); ?>
    </div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/includeAutosize.php'); ?>
</body>

</html>