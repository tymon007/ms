<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/server.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/langPLUSme.php');

$likes = $me->select('postuser', ['IDusersLiked'], ['id' => $_POST['idPost']])[0]['IDusersLiked'];

if ($likes === NULL) {
    $idUsersLikedPostString = $_POST['idWhoLiked'];
} else {
    $idUsersLikedPostString = $likes . ';' . $_POST['idWhoLiked'];
}

$me->update('postuser', ['IDusersLiked' => $idUsersLikedPostString], ['id' => $_POST['idPost']]);
