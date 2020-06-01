<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/server.php');

$resultDate = gm2local($_POST['timestamp'], $_POST['tzo']);

echo mygetdate($resultDate);
