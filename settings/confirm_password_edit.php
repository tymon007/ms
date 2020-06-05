<?php
require_once '../_PARTS_/server.php';

$login = $_SESSION['login'];
$me = new Me($login);

if ($_GET['edit'] == 'true') {
    $salt = $_GET['salt'];
    $newpassword = $_GET['pass'];
    $me->update('users', ['salt' => $salt, 'password' => $newpassword], ['id' => $me->id]);
    $title = 'Changed password';
    $message = 'Your password have been changed';
    sendMessageMail($me->login, EMAIL, $title, $message);
    header("Location: /6Settings/successfully_edited_password.php");
    exit;
}
