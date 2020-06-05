<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/server.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/langPLUSme.php');

if ($_POST['title'] == "") {
    $me->insert("postuser", [
        'whoID' => $_POST['whoID'],
        'bossPageID' => $_POST['bossPageID'],
        'title' => NULL,
        'text' => nl2br(entities($_POST['text'])),
        'time' => local2gm(time()),
        'pictures' => NULL,
        'video' => NULL,
        'audio' => NULL,
        'docs' => NULL,
        'forward' => 'no'
    ]);
} else {
    $me->insert("postuser", [
        'whoID' => $_POST['whoID'],
        'bossPageID' => $_POST['bossPageID'],
        'title' => nl2br(entities($_POST['title'])),
        'text' => nl2br(entities($_POST['text'])),
        'time' => local2gm(time()),
        'pictures' => NULL,
        'video' => NULL,
        'audio' => NULL,
        'docs' => NULL,
        'forward' => 'no'
    ]);
}
