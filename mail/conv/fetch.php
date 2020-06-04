<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/server.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/langPLUSme.php');

$tzo = $_REQUEST['time'];

$messages = $me->select('messages', ['*'], ['chatID' => $_REQUEST['chatID']], ['id' => 1]);

for ($i = 0; $i < count($messages); $i++) {
    $user = $me->select('users', ['*'], ['id' => $messages[$i]['fromID']])[0];

    $image = $user['image'];

    if ($image === NULL) {
        $image = "/img/01I.png";
    } else {
        $image = "/userimg/users/" . $image;
    }

    $time = gm2local($messages[$i]['time'], $tzo);

    $names = $user['firstName'];

    if (date('d.m.Y', gm2local($messages[$i - 1]['time'], $tzo)) !== date('d.m.Y', $time)) {
        echo '<div class="message" data-type="admin">';
        echo '    <div class="text">' . date('d.m.Y', $time) . '</div>';
        echo '</div>';
    }

    if ($messages[$i]['type'] == 1) {
        echo '<div class="message" data-type="admin">';
        echo '    <div class="text">' . $messages[$i]['text'] . '</div>';
        echo '</div>';
    } else {
        echo '<div class="message">';
        echo '    <div class="image" style="background-image: url(\'' . $image . '\')"></div>';
        echo '    <div class="other">';
        echo '        <div class="name-time">';
        echo '            <div class="name">' . $names . '</div>';
        echo '            <div class="time">' . date('H:i', $time) . '</div>';
        echo '        </div>';
        echo '        <div class="text">' . $messages[$i]['text'] . '</div>';
        echo '    </div>';
        echo '</div>';
    }
}
