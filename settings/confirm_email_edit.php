<?php
require_once '../_PARTS_/server.php';

$login = $_SESSION['login'];
$me = new Me($login);

if ($_GET['edit'] == 'true') {
    $email = $_GET['email'];
    $me->update('users', ['login' => $email], ['id' => $me->id]);
    $_SESSION['login'] = $email;
    $title = 'Changed email';
    $message = 'Your email have been changed';
    sendMessageMail($me->login, EMAIL, $title, $message);
    header("Location: /6Settings/successfully_edited_email.php");
    exit;
}
