<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/server.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/langPLUSme.php');

$chat = $me->select("chats", ['*'], ['id' => $_POST['chatId']])[0];

$convName = nl2br(trim(entities(str_replace("'", "\\'", str_replace("\\", "\\\\", $_POST['convName'])))));

$convDescription = nl2br(trim(entities(str_replace("'", "\\'", str_replace("\\", "\\\\", $_POST['convDesc'])))));

if (
    !empty($_POST['sentMess']) &&
    !empty($_POST['sentMess']) &&
    !empty($_POST['sentMess']) &&
    !empty($_POST['sentMess']) &&
    !empty($_POST['sentMess']) &&
    !empty($_POST['sentMess']) &&
    !empty($_POST['sentMess']) &&
    !empty($_POST['sentMess'])
) {
    $permissions[] = $_POST['sentMess'] == 'undefined' ? 1 : ($_POST['sentMess'] == 'true' ? 1 : 0);
    $permissions[] = $_POST['sentMedia'] == 'undefined' ? 1 : ($_POST['sentMedia'] == 'true' ? 1 : 0);
    $permissions[] = $_POST['sentGIFs'] == 'undefined' ? 1 : ($_POST['sentGIFs'] == 'true' ? 1 : 0);
    $permissions[] = $_POST['linkPreview'] == 'undefined' ? 1 : ($_POST['linkPreview'] == 'true' ? 1 : 0);
    $permissions[] = $_POST['makiPolls'] == 'undefined' ? 1 : ($_POST['makiPolls'] == 'true' ? 1 : 0);
    $permissions[] = $_POST['addMembers'] == 'undefined' ? 1 : ($_POST['addMembers'] == 'true' ? 1 : 0);
    $permissions[] = $_POST['pinMess'] == 'undefined' ? 1 : ($_POST['pinMess'] == 'true' ? 1 : 0);
    $permissions[] = $_POST['changeProf'] == 'undefined' ? 1 : ($_POST['changeProf'] == 'true' ? 1 : 0);
    $convPermissions = implode(':', $permissions);

    if ($chat['permissions'] != $convPermissions) $me->update('chats', ['permissions' => $convPermissions], ['id' => $_POST['chatId']]);
}

if (!empty($_FILES)) {
    $filePath  = $_FILES['convImage']['tmp_name'];
    $errorCode = $_FILES['convImage']['error'];

    if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($filePath)) {

        $errorMessages = [
            UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
            UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
            UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
            UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
            UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
            UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
            UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
        ];

        $unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';

        $outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;

        die($outputMessage);
    }

    $fi = finfo_open(FILEINFO_MIME_TYPE);

    $mime = (string) finfo_file($fi, $filePath);

    if (strpos($mime, 'image') === false) die('Можно загружать только изображения.');

    $image = getimagesize($filePath);

    $limitBytes  = 1024 * 1024 * 20; // 20 MB
    $minWidth = $minHeight = 200;
    $maxSize = 14000;
    $limitWidth  = 1280;
    $limitHeight = 768;

    if (filesize($filePath) > $limitBytes)                die('Размер изображения не должен превышать 20 Мбайт.');
    if ($image[0] < $minWidth || $image[1] < $minHeight)  die('Минимальный размер фотографии — 200х200 пикселей.');
    if ($image[0] + $image[1] >= $maxSize)                die('Максимальная сумма высоты и ширины фотографии — 14 000 px.');

    $name = md5_file($filePath) . md5(time());

    $extension = image_type_to_extension($image[2]);

    $format = str_replace('jpeg', 'jpg', $extension);

    $convImage = $name . $format;

    if (!move_uploaded_file($filePath, 'd:/OpenServer/domains/data.rpg.com/userimg/chats/' . $convImage)) {
        die('При записи изображения на диск произошла ошибка.');
    }

    $me->update('chats', ['image' => $convImage], ['id' => $_POST['chatId']]);
}

if ($chat['name'] != $convName) $me->update('chats', ['name' => $convName], ['id' => $_POST['chatId']]);

if ($chat['description'] != $convDescription) $me->update('chats', ['description' => $convDescription], ['id' => $_POST['chatId']]);
