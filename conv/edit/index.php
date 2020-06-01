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
        echo 'Manage group';
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
            <div class="groupBlock">
                <div class="editBlock">
                    <input type="file" name="image4conv" class="display-none" id="image4conv" accept=".jpg, .jpeg, .png">
                    <?php
                    $image = $chat['image'];
                    if ($image === NULL) {
                        $image = '/img/user_group.svg';
                    } else {
                        $image = '/userimg/chats/' . $image;
                    }
                    ?>
                    <div class="convImage" style="background-image: url('<?php echo ADDRESS_DATA . $image; ?>')"></div>
                </div>
            </div>

            <div class="groupBlock">
                <div class="editBlock">
                    <input type="text" placeholder="Name" value="<?php echo $chat['name']; ?>" autocomplete="off" class="textElem form-control" id="name" maxlength="128" required>

                    <div class="valid-feedback" id="invalidConvName"></div>
                </div>


                <div class="editBlock">
                    <textarea placeholder="Description (not required)" autocomplete="off" class="textElem form-control autoresizeTextarea" id="description" maxlength="256"><?php echo $chat['description']; ?></textarea>
                </div>
            </div>

            <div class="groupBlock">
                <div class="editBlock">
                    <button type="button" class="activeMyModal btn my_btn" data-my-target='permissions'>Permissions</button>

                    <?php
                    $permissions = explode(":", $chat['permissions']);
                    ?>
                    <div class='my_modal _nonActive' id='permissions'>
                        <div class='my_modalContent'>
                            <div class='my_modalContentTitle'>Permissions</div>

                            <div class='my_modalContentBody table'>
                                <div class="table-row">
                                    <div class="table-cell-1">
                                        <label for="customSwitch1">Senting messages</label>
                                    </div>

                                    <div class="table-cell-2 custom-control custom-switch">
                                        <input type="checkbox" name="sentMess" class="custom-control-input" id="customSwitch1" <?php if ($permissions[0] == 1) echo 'checked'; ?>>

                                        <label class="custom-control-label"></label>
                                    </div>
                                </div>

                                <div class="table-row">
                                    <div class="table-cell-1">
                                        <label for="customSwitch2">Senting mediafiles</label>
                                    </div>

                                    <div class="table-cell-2 custom-control custom-switch">
                                        <input type="checkbox" name="sentMedia" class="custom-control-input" id="customSwitch2" <?php if ($permissions[1] == 1) echo 'checked'; ?>>

                                        <label class="custom-control-label"></label>
                                    </div>
                                </div>

                                <div class="table-row">
                                    <div class="table-cell-1">
                                        <label for="customSwitch3">Senting stickers and GIFs</label>
                                    </div>

                                    <div class="table-cell-2 custom-control custom-switch">
                                        <input type="checkbox" name="sentGIFs" class="custom-control-input" id="customSwitch3" <?php if ($permissions[2] == 1) echo 'checked'; ?>>

                                        <label class="custom-control-label"></label>
                                    </div>
                                </div>

                                <div class="table-row">
                                    <div class="table-cell-1">
                                        <label for="customSwitch4">Links preview</label>
                                    </div>

                                    <div class="table-cell-2 custom-control custom-switch">
                                        <input type="checkbox" name="linkPreview" class="custom-control-input" id="customSwitch4" <?php if ($permissions[3] == 1) echo 'checked'; ?>>

                                        <label class="custom-control-label"></label>
                                    </div>
                                </div>

                                <div class="table-row">
                                    <div class="table-cell-1">
                                        <label for="customSwitch5">Making polls</label>
                                    </div>

                                    <div class="table-cell-2 custom-control custom-switch">
                                        <input type="checkbox" name="makiPolls" class="custom-control-input" id="customSwitch5" <?php if ($permissions[4] == 1) echo 'checked'; ?>>

                                        <label class="custom-control-label"></label>
                                    </div>
                                </div>

                                <div class="table-row">
                                    <div class="table-cell-1">
                                        <label for="customSwitch6">Adding members</label>
                                    </div>

                                    <div class="table-cell-2 custom-control custom-switch">
                                        <input type="checkbox" name="addMembers" class="custom-control-input" id="customSwitch6" <?php if ($permissions[5] == 1) echo 'checked'; ?>>

                                        <label class="custom-control-label"></label>
                                    </div>
                                </div>

                                <div class="table-row">
                                    <div class="table-cell-1">
                                        <label for="customSwitch7">Pining message</label>
                                    </div>

                                    <div class="table-cell-2 custom-control custom-switch">
                                        <input type="checkbox" name="pinMess" class="custom-control-input" id="customSwitch7" <?php if ($permissions[6] == 1) echo 'checked'; ?>>

                                        <label class="custom-control-label"></label>
                                    </div>
                                </div>

                                <div class="table-row">
                                    <div class="table-cell-1">
                                        <label for="customSwitch8">Changing groups profile</label>
                                    </div>

                                    <div class="table-cell-2 custom-control custom-switch">
                                        <input type="checkbox" name="changeProf" class="custom-control-input" id="customSwitch8" <?php if ($permissions[7] == 1) echo 'checked'; ?>>

                                        <label class="custom-control-label"></label>
                                    </div>
                                </div>
                            </div>

                            <div class='my_modalContentFooter'>
                                <div class='submition-container'>
                                    <div class='submition'>
                                        <input type='submit' value='Save' id='permissionsSave' class='btn btn-light submit'>

                                        <button type='button' class='btn my_btn closeMyModal'>Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="editBlock">
                    <button type="button" class="activeMyModal btn my_btn" data-my-target='admins'>Admins</button>

                    <div class='my_modal _nonActive' id='admins'>
                        <div class='my_modalContent'>
                            <div class='my_modalContentTitle'>Admins</div>

                            <?php
                            if ($chat['admins'] == '') {
                                $admins = [];
                            } else {
                                $admins = explode(';', $chat['admins']);
                            }

                            $admins = array_merge($admins, [$chat['creator']]);

                            for ($i = 0; $i < count($admins); $i++) {
                                $user = $me->select('users', ['*'], ['id' => $admins[$i]])[0];
                                echo '<div class="my_modalContentBody table">';
                                echo '    <div class="table-row">';
                                echo '        <div class="table-cell-1">';
                                echo $user['firstName'] . ' ' . $user['lastName'];
                                echo '        </div>';
                                echo '        <div class="table-cell-2 custom-control custom-switch">';
                                echo '            Delete';
                                echo '        </div>';
                                echo '    </div>';
                                echo '</div>';
                            }
                            ?>

                            <div class='my_modalContentFooter'>
                                <div class='submition-container'>
                                    <div class='submition'>
                                        <input type='submit' name='submit' value='Send' id='statusSubmit' class='btn btn-light submit'>

                                        <button type='button' class='btn my_btn closeMyModal'>Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="editBlock">
                    <button type="button" class="activeMyModal btn my_btn" data-my-target='members'>Members</button>

                    <div class='my_modal _nonActive' id='members'>
                        <div class='my_modalContent'>
                            <div class='my_modalContentTitle'>Members</div>

                            <div class='my_modalContentBody table'>
                                <?php
                                $allparticipants = explode(';', $chat['participants']);

                                for ($i = 0; $i < count($allparticipants); $i++) {
                                    $user = $me->select('users', ['*'], ['id' => $allparticipants[$i]])[0];
                                    echo '<div class="my_modalContentBody table">';
                                    echo '    <div class="table-row">';
                                    echo '        <div class="table-cell-1">';
                                    echo $user['firstName'] . ' ' . $user['lastName'];
                                    echo '        </div>';
                                    echo '        <div class="table-cell-2 custom-control custom-switch">';
                                    echo '            Delete';
                                    echo '        </div>';
                                    echo '    </div>';
                                    echo '</div>';
                                }
                                ?>
                            </div>

                            <div class='my_modalContentFooter'>
                                <div class='submition-container'>
                                    <div class='submition'>
                                        <input type='submit' name='submit' value='Send' id='statusSubmit' class='btn btn-light submit'>

                                        <button type='button' class='btn my_btn closeMyModal'>Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="groupBlock">
                <div class="editBlock">
                    <div class="remove">REMOVE</div>
                </div>
            </div>

            <div class="submition-container">
                <div class="submition">
                    <button type="button" class="btn btn-light submit" id="create-pseudo-submit">Edit</button>

                    <div class="my_link cancel" data-href="/mail/conv?id=<?php echo $_GET['id']; ?>">
                        <button type="button" class="btn my_btn">Cancel</button>
                    </div>
                </div>

            </div>

            <div class='display-none' id='DATA-TO-CHAN-CONV' data-chat-id="<?php echo $_GET['id']; ?>"></div>
        </div>

        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/3footer.php'); ?>
    </div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/includeAutosize.php'); ?>
</body>

</html>