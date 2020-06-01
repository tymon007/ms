<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/server.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/langPLUSme.php');

$chat = $me->select('chats', ['*'], ['id' => $_POST['chatId']])[0];
$allparticipant = explode(";", $chat['participants']);
$result = implode(';', array_merge($_POST['ids'], $allparticipant));

$me->update('chats', ['participants' => $result], ['id' => $_POST['chatId']]);

$text = "";
for ($i = 0; $i < count($_POST['ids']); $i++) {
    $user = $me->select('users', ['*'], ['id' => $_POST['ids'][$i]])[0];
    if ($i == (count($_POST['ids']) - 1)) {
        $text .= $user['firstName'];
    } else {
        $text .= $user['firstName'] . ', ';
    }
}
if (count($_POST['ids']) == 1) {
    $text .= ' was added by';
} else {
    $text .= ' were added by';
}
$text .= ' ' . $me->firstName;
$me->insert('messages', [
    'fromID' => 0,
    'chatID' => $_POST['chatId'],
    'text' => nl2br(trim(entities(str_replace("'", "\\'", str_replace("\\", "\\\\", $text))))),
    'time' => local2gm(time()),
    'type' => 1
]);
