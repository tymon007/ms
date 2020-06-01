<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/service.php');

if (MAINTENANCE) {
    header('Location: ' . ADDRESS_M . '/_EXEPTIONS_/maintenance.php');
    exit;
}

$BDfunc = new Me("");
$emailFree = $BDfunc->select('users', ['login'], ['login' => $_POST['text']]);
echo count($emailFree);
