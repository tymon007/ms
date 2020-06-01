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
        echo 'Dialog';
    }
    ?>
</head>

<body>
    <div class='container_body'>
        <div class="pseudo_header"></div>

        <div class="header">
            <div class="logo">
                <div class="my_link" data-href="/mail/">
                    <img src="<?php echo ADDRESS_DATA; ?>/img/back.svg" width="40px">
                </div>
            </div>

            <div class="menu">
                <div class="container_for_buttons">
                    <marquee class="buttElement nameOfConv">
                        <?php echo $chat['name'] ?>
                    </marquee>

                    <div class="buttElement mDropdown">
                        <div class="mDropdownTit">
                            <img src="<?php echo ADDRESS_DATA; ?>/img/more_vert.svg" width="40px">
                        </div>

                        <div class="mDropdownCon">
                            <div class="mDropdownConElem my_link" data-href="edit?id=<?php echo $_GET['id']; ?>">Manage group</div>

                            <?php
                            if ($chat['is_between2users'] == 'false') {
                                echo '<div class="mDropdownConElem my_link" data-href="add?id=' . $_GET['id'] . '">Add members</div>';
                            }
                            ?>

                            <div class="mDropdownConElem">Clear history</div>

                            <div class="mDropdownConElem">Leave group</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class='feature'>
            <div class="messages" id="messages"></div>

            <div class="input">
                <!-- <div class="attach" style="background-image: url('<?php echo ADDRESS_DATA . '/img/paper_clip.svg'; ?>')"></div> -->
                <textarea class="writeMessage autoresizeTextarea" placeholder="Enter message" id="input"></textarea>
                <!-- <div class="emoji" style="background-image: url('<?php echo ADDRESS_DATA . '/img/emoji.png'; ?>')"></div> -->
                <div class="send" style="background-image: url('<?php echo ADDRESS_DATA . '/img/sent.svg'; ?>')" id="send"></div>
            </div>

            <div class='display-none' id='DATA-TO-SEND-MESS' data-chat-id="<?php echo $_GET['id']; ?>"></div>
        </div>

        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/3footer.php'); ?>
    </div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/includeAutosize.php'); ?>
</body>

</html>