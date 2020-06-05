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
        global $me;
        echo $me->firstName . ' ' . $me->lastName;
    }
    ?>

    <style>
        .posts .post .likes-comments-forwards .likes._no .icon {
            background-image: url("<?php echo ADDRESS_DATA; ?>/img/like_no.svg");
        }

        .posts .post .likes-comments-forwards .comments._no .icon {
            background-image: url("<?php echo ADDRESS_DATA; ?>/img/comment_no.svg");
        }

        .posts .post .likes-comments-forwards .forwards._no .icon {
            background-image: url("<?php echo ADDRESS_DATA; ?>/img/forward_no.svg");
        }

        .posts .post .likes-comments-forwards .likes._yes .icon {
            background-image: url("<?php echo ADDRESS_DATA; ?>/img/like_yes.svg");
        }

        .posts .post .likes-comments-forwards .comments._yes .icon {
            background-image: url("<?php echo ADDRESS_DATA; ?>/img/comment_yes.svg");
        }

        .posts .post .likes-comments-forwards .forwards._yes .icon {
            background-image: url("<?php echo ADDRESS_DATA; ?>/img/forward_yes.svg");
        }
    </style>
</head>

<body>
    <div class='container_body'>

        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/2header.php'); ?>

        <div class='feature'>
            <div class='intro'>
                <?php
                if ($me->image === null) {
                    if ($me->gender == 'male') $image = '/img/user_male.svg';
                    elseif ($me->gender == 'female') $image = '/img/user_female.svg';
                } else {
                    $image = '/userimg/users/' . $me->image;
                }
                ?>
                <div class='image' style="background-image: url('<?php echo ADDRESS_DATA . $image; ?>')"></div>
                <span class='title'><?php echo $me->firstName; ?> <?php echo $me->lastName; ?></span>

                <?php
                if ($me->status === null) {
                    $status = 'You do not have a status now';
                    $isStatus = 'false';
                } else {
                    $status = $me->status;
                    $isStatus = 'true';
                }
                ?>

                <div class='pseudoStatus'>
                    <div class='activeMyModal' data-is-status="<?php echo $isStatus; ?>" data-my-target='status'><?php echo $status; ?></div>
                </div>

                <div class='my_modal _nonActive' id='status'>
                    <div class='my_modalContent'>
                        <div class='my_modalContentTitle'>Change status!</div>

                        <div class='my_modalContentBody'>
                            <div class='input-group mb-3'>
                                <textarea class='form-control' placeholder='Enter new status!' id='newStatus' maxlength='200'></textarea>
                            </div>

                            <div class='col-auto my-1'>
                                <div class='custom-control custom-checkbox mr-sm-2'>
                                    <input type='checkbox' class='custom-control-input' id='deleteStatus'>
                                    <label class='custom-control-label' for='deleteStatus' style='font-size: 1rem;'>Delete status</label>
                                </div>
                            </div>
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

            <div class='space'></div>

            <div class='myInformations'>
                <div class='information'>
                    <div class='title'>Gender</div>

                    <div class='verticalLine'></div>

                    <div class='data'>
                        <?php
                        if ($me->gender == 'male') {
                            echo 'Male';
                        } elseif ($me->gender == 'female') {
                            echo 'Female';
                        }
                        ?>
                    </div>
                </div>

                <div class='information'>
                    <div class='title'>Date of birth</div>

                    <div class='verticalLine'></div>

                    <div class='data'><?php echo date('d.m.Y', mktime(null, null, null, $me->month, $me->day, $me->year)); ?></div>
                </div>

                <div class='information'>
                    <div class='title'>Groups</div>

                    <div class='verticalLine'></div>

                    <div class='data'>
                        <span class='my_link insdlink' data-href=''>Lalalandia</span>
                        <span class='my_link insdlink' data-href=''>Ozroke</span>
                        <span class='my_link insdlink' data-href=''>RoleGame Official Community</span>
                        <span class='my_link insdlink' data-href=''>michala</span>
                        <span class='my_link insdlink' data-href=''>leronta</span>
                        <span class='my_link insdlink' data-href=''>Brizrain</span>
                        <span class='my_link insdlink' data-href=''>Brain Maps</span>
                        <span class='my_link insdlink' data-href=''>Lololoshka</span>
                        <span class='my_link insdlink' data-href=''>Justin Biber Fun Club</span>
                    </div>
                </div>

                <div class='information'>
                    <div class='title'>Photo</div>

                    <div class='verticalLine'></div>

                    <div class='data'></div>
                </div>

                <div class='information'>
                    <div class='title'>Music</div>

                    <div class='verticalLine'></div>

                    <div class='data'></div>
                </div>

                <div class='information'>
                    <div class='title'>Video</div>

                    <div class='verticalLine'></div>

                    <div class='data'></div>
                </div>
            </div>

            <div class='space'></div>

            <div class='pseudoWritePost'>
                <div class='input-group'>
                    <textarea class='form-control activeMyModal' aria-label='With textarea' placeholder='Write something here' data-my-target='writePost'></textarea>
                </div>
            </div>

            <div class='my_modal _nonActive' id='writePost'>
                <div class='my_modalContent'>
                    <div class='my_modalContentTitle'>Write Post!</div>

                    <div class='my_modalContentBody'>
                        <div class='input-group mb-3'>
                            <input type='text' class='form-control' aria-label='With textarea' placeholder='Title' id='postTitle'></textarea>
                        </div>

                        <div class='input-group'>
                            <textarea class='form-control autoresizeTextarea' aria-label='With textarea' placeholder='Write something here' id='postText'></textarea>
                        </div>
                    </div>

                    <div class='my_modalContentFooter'>
                        <div class='submition-container'>
                            <div class='submition'>
                                <input type='submit' name='submit' value='Send' id='sendPostSubmit' class='btn btn-light submit'>

                                <button type='button' class='btn my_btn closeMyModal'>Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='posts'>
                <?php
                $postsOnMyPage = $me->select('postuser', ['*'], ['bossPageID' => $me->id], ['id' => -1]);
                for ($i = 0; $i < count($postsOnMyPage); $i++) {
                    echo post($postsOnMyPage[$i]['id'], $postsOnMyPage[$i]['whoID'], $postsOnMyPage[$i]['title'], $postsOnMyPage[$i]['text'], $postsOnMyPage[$i]['time'], $postsOnMyPage[$i]['forward'], $postsOnMyPage[$i]['IDusersLiked'], 'at');
                }
                ?>
            </div>

            <div class='display-none' id='DATA-TO-SEND-POST' data-my-id="<?php echo $me->id; ?>" data-alert-empty-textarea='Empty text area!'></div>
        </div>

        <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/3footer.php'); ?>
    </div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/includeAutosize.php'); ?>
</body>

</html>