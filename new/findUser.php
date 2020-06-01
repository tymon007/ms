<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/server.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/langPLUSme.php');

$value = $_REQUEST['value'];
$newUsers = [];
$users = $me->select('users', ['id', 'image', 'firstName', 'lastName']);
for ($i = 0, $j = 0; $i < count($users); $i++) {
    $firstname = strtolower($users[$i]['firstName']);
    $lastname = strtolower($users[$i]['lastName']);
    if (
        preg_match("/$value/", $firstname) == 1 ||
        preg_match("/$value/", $lastname) == 1 ||
        preg_match("/$value/", $firstname . " " . $lastname) == 1 ||
        preg_match("/$value/", $lastname . " " . $firstname) == 1
    ) {
        $image = $users[$i]['image'];
        if ($image === NULL) {
            $image = ADDRESS_DATA . '/img/01I.png';
        } else {
            $image = ADDRESS_DATA . '/userimg/users/' . $image;
        }
        $newUsers[$j]['id'] = $users[$i]['id'];
        $newUsers[$j]['firstName'] = $users[$i]['firstName'];
        $newUsers[$j]['lastName'] = $users[$i]['lastName'];
        $newUsers[$j]['image'] = $image;
        $j++;
    }
}
echo json_encode($newUsers);
