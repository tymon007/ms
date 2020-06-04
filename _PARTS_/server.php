<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/service.php');

if (MAINTENANCE) {
    header('Location: /_EXEPTIONS_/maintenance.php');
    exit;
}

if (isset($_GET['exit']) == true) {
    $_SESSION = [];
    header('Location: /');
    exit;
}

if (!isset($_SESSION['login'])) {
    $_SESSION = [];
    header('Location: /log/?notLogin=true&thisPage=' . $_SERVER['REQUEST_URI']);
    exit;
}
