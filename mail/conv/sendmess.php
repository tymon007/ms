<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/server.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/langPLUSme.php');

if (trim($_POST['text']) != "") {
    $me->insert('messages', [
        'fromID' => $me->id,
        'chatID' => $_REQUEST['chatID'],
        'text' => nl2br(trim(entities($_REQUEST['text']))),
        'time' => local2gm(time()),
        'type' => 0
    ]);
}
