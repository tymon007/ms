<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/service.php');

if (MAINTENANCE) {
    header('Location: /_EXEPTIONS_/maintenance.php');
    exit;
}

$BDfunc = new Me("");
$emailFree = $BDfunc->select('users', ['username'], ['username' => $_POST['text']]);
echo count($emailFree);
