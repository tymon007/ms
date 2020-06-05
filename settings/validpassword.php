<?php
require_once '../_PARTS_/server.php';

$login = $_SESSION['login'];
$me = new Me($login);

if ($me->password == md5(md5($_POST['pass']) . $me->salt)) {
    echo 'valid';
} else {
    echo 'invalid';
}
