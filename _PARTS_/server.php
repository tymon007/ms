<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/service.php');

if (isset($_GET['exit']) == true) {
    $_SESSION = [];
    header('Location: ' . ADDRESS_M);
    exit;
}

if (!isset($_SESSION['login'])) {
    $_SESSION = [];
    header('Location: ' . ADDRESS_M . '/log/?notLogin=true&thisPage=' . $_SERVER['REQUEST_URI']);
    exit;
}
