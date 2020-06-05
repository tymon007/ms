<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/server.php');

$resultDate = gm2local($_POST['timestamp'], $_POST['tzo']);

$datetime = getdate($resultDate);
if ($datetime['mday'] < 10) $datetime['mday'] = '0' . $datetime['mday'];
if ($datetime['mon'] < 10) $datetime['mon'] = '0' . $datetime['mon'];
if ($datetime['hours'] < 10) $datetime['hours'] = '0' . $datetime['hours'];
if ($datetime['minutes'] < 10) $datetime['minutes'] = '0' . $datetime['minutes'];
$date = $datetime['mday'] . '.' . $datetime['mon'] . '.' . $datetime['year'];
$time = $datetime['hours'] . ':' . $datetime['minutes'];

echo $date . '|' . $time;
