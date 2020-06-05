<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/server.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/langPLUSme.php');

$likes = $me->select('postuser', ['IDusersLiked'], ['id' => $_POST['idPost']])[0]['IDusersLiked'];

if ($likes !== NULL) {
    $idUsersLikedPostList = explode(';', $likes);
    $key = array_search($me->id, $idUsersLikedPostList);
    unset($idUsersLikedPostList[$key]);
    $idUsersLikedPostString = implode(';', $idUsersLikedPostList);
    if ($idUsersLikedPostString == "") $idUsersLikedPostString = null;
    $me->update('postuser', ['IDusersLiked' => $idUsersLikedPostString], ['id' => $_POST['idPost']]);
}
