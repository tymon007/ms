<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/server.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/langPLUSme.php');

$deleteKey = $_POST['deleteKey'];
$value = nl2br(entities($_POST['value']));

if ($deleteKey == 'true') {
    $me->update('users', ['status' => NULL], ['id' => $me->id]);
} else {
    if (trim($value) != "") {
        $me->update('users', ['status' => $value], ['id' => $me->id]);
    } else {
        $me->update('users', ['status' => NULL], ['id' => $me->id]);
    }
}
