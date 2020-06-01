<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/server.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/langPLUSme.php');

$chat = $me->select('chats', ['*'], ['id' => $_GET['id']])[0];
?>
<!DOCTYPE html>
<html>

<head>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/1head.php');

    function head_title()
    {
        echo 'Add users';
    }
    ?>
</head>

<body>
    <div class='container_body'>
        <div class="pseudo_header"></div>

        <div class="header">
            <div class="logo">
                <div class="my_link" data-href="/mail/conv?id=<?php echo $_GET['id']; ?>">
                    <img src="<?php echo ADDRESS_DATA; ?>/img/back.svg" width="40px">
                </div>
            </div>

            <div class="menu">
                <div class="container_for_buttons">
                    <div class="buttElement">
                        NAME
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class='feature'>
            <div class="cont_search_user">
                <input type="search" placeholder="Search" class="search_user">
                <div class="search_icon">
                    <img src="<?php echo ADDRESS_DATA; ?>/img/search.svg" width="40px">
                </div>
            </div>

            <div class="users">
                <?php
                $users = $me->select('users', ['firstName', 'lastName', 'image', 'id', 'gender']);
                $allparticipants = explode(";", $chat['participants']);
                for ($i = 0; $i < count($users); $i++) {
                    $image = $users[$i]['image'];
                    if ($image === NULL) {
                        if ($users[$i]['gender'] == 'male') $image = '/img/user_male.svg';
                        elseif ($users[$i]['gender'] == 'female') $image = '/img/user_female.svg';
                    } else {
                        $image = '/userimg/users/' . $image;
                    }
                    $names = $users[$i]['firstName'] . ' ' . $users[$i]['lastName'];
                    $isAlreadyMember = "false";
                    if (in_array($users[$i]['id'], $allparticipants)) {
                        $isAlreadyMember = "true";
                    }
                    echo '<div class="user" data-user-id="' . $users[$i]['id'] . '" data-is-selected="false" data-is-already-member="' . $isAlreadyMember . '">';
                    echo '    <div class="image" style="background-image: url(\'' . ADDRESS_DATA . $image . '\')"></div>';
                    echo '    <div class="name">' . $names . '</div>';
                    echo '</div>';
                }
                ?>
            </div>

            <div class='display-none' id='DATA-TO-CHOO-USER' data-chat-id="<?php echo $_GET['id']; ?>"></div>

            <div class="nextStepToCreateConversation" style="background-image: url('<?php echo ADDRESS_DATA . '/img/next.svg'; ?>')"></div>
        </div>

        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/3footer.php'); ?>
    </div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/includeAutosize.php'); ?>
</body>

</html>