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
    <div class='container_body'>
        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/2header.php'); ?>

        <div class='feature'>
            <div class="activities">
                <div class="my_link" data-href="new">
                    <img src="/img/message.svg" width="40px">
                </div>

                <div class="my_link" data-href="">
                    <img src="/img/trash.svg" width="40px">
                </div>

                <div class="my_link" data-href="">
                    <img src="/img/block.svg" width="40px">
                </div>
            </div>

            <div class="cont_search_conv">
                <input type="search" placeholder="Search" class="search_conv">
                <div class="search_icon">
                    <img src="/img/search.svg" width="40px">
                </div>
            </div>

            <div class="messages">
                <?php
                $chats = $me->select('chats', ['*']); // all existing chats
                $mychat = []; // array for my chats
                $allparticipants = []; // array for id of all members of chat

                for ($i = 0; $i < count($chats); $i++) {
                    $allparticipants = explode(";", $chats[$i]['participants']);
                    if (in_array($me->id, $allparticipants)) {
                        if ($chats[$i]['is_between2users'] == 'true') {
                            $messages = $me->select('messages', ['*'], ['chatID' => $chats[$i]['id']]);
                            if (count($messages) != 0) {
                                $mychat[] = $chats[$i];
                            }
                        } else {
                            $mychat[] = $chats[$i];
                        }
                    }
                    $allparticipants = NULL;
                }

                for ($i = 0; $i < count($mychat); $i++) {
                    $lastMessageInCurrChat = $me->select('messages', ['*'], ['chatID' => $mychat[$i]['id']], ['id' => -1], 1)[0];
                    $mychat[$i]['lastMessage'] = $lastMessageInCurrChat;
                }

                usort($mychat, function ($a, $b) {
                    if ($a['lastMessage']['id'] > $b['lastMessage']['id']) {
                        return -1;
                    } elseif ($a['lastMessage']['id'] < $b['lastMessage']['id']) {
                        return 1;
                    }
                    return 0;
                });

                for ($i = 0; $i < count($mychat); $i++) {
                    $allparticipants = explode(';', $mychat[$i]['participants']);

                    if ($mychat[$i]['is_between2users'] === 'true') {
                        // two-user converstion

                        $neededUserId;

                        if (count($allparticipants) == 1) {
                            $neededUserId = $me->id;
                        } else {
                            foreach ($allparticipants as $userId) {
                                if ($userId != $me->id) {
                                    $neededUserId = $userId;
                                }
                            }
                        }

                        $user = $me->select('users', ['*'], ['id' => $neededUserId])[0];

                        $image = $user['image'];
                        if ($image === NULL) {
                            if ($user['gender'] == 'male') $image = '/img/user_male.svg';
                            elseif ($user['gender'] == 'female') $image = '/img/user_female.svg';
                        } else {
                            $image = '/userimg/users/' . $image;
                        }

                        if (count($allparticipants) == 1) {
                            $title = 'Me';
                        } else {
                            $title = $user['firstName'] . ' ' . $user['lastName'];
                        }
                    } else {
                        // many users conversation

                        $image = $mychat[$i]['image'];
                        if ($image === NULL) {
                            $image = '/img/user_group.svg';
                        } else {
                            $image = '/userimg/chats/' . $image;
                        }

                        $title = $mychat[$i]['name'];
                        if ($title === NULL) {
                            $str = "";
                            for ($i = 0; $i < count($allparticipants); $i++) {
                                $user = $me->select('users', ['firstName', 'lastName'], ['id' => $allparticipants[$i]])[0];
                                $str .= $user['firstName'] . ' ' . $user['lastName'];
                                if ($i != (count($allparticipants) - 1)) {
                                    $str .= ', ';
                                }
                            }
                            $title = $str;
                        }
                    }

                    $lastMessage = $me->select('messages', ['*'], ['chatID' => $mychat[$i]['id']], ['id' => -1], 1)[0];

                    echo '<div class="message my_link" data-href="conv?id=' . $mychat[$i]['id'] . '">';
                    echo '    <div class="image" style="background-image: url(\'' . $image . '\')"></div>';
                    echo '    <div class="other">';
                    echo '        <div class="titleAndTime">';
                    echo '            <div class="title">' . $title . '</div>';
                    echo '            <div class="time" data-timestamp="' . $lastMessage['time'] . '"></div>';
                    echo '        </div>';
                    echo '        <div class="lastMessage">' . $lastMessage['text'] . '</div>';
                    echo '    </div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>

        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/3footer.php'); ?>
    </div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/includeAutosize.php'); ?>
</body>

</html>