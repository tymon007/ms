<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/server.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/_PARTS_/langPLUSme.php');

if ($_POST['btw2users'] == 'true') {
    $chats = $me->select("chats", ['*']);
    for ($i = 0; $i < count($chats); $i++) {
        if ($chats[$i]['is_between2users'] == 'true') {
            $allparticipant = explode(';', $chats[$i]['participants']);
            $iAndM = $_POST['ids'];
            $iAndM[] = $me->id;
            $iAndM = array_unique($iAndM);
            $diff = deleteNotUniqeValues($allparticipant, $iAndM);
            if (empty($diff)) {
                $id = $chats[$i]['id'];
                echo $id;
                exit;
            }
        }
    }
    $key = uniqid(bin2hex(random_bytes(10)), true) . getmypid();
    $allparticipant = $_POST['ids'];
    $allparticipant[] = $me->id;
    $allparticipant = array_unique($allparticipant);
    $me->insert('chats', [
        'is_between2users' => 'true',
        'uniqueKey' => $key,
        'creator' => $me->id,
        'participants' => implode(';', $allparticipant)
    ]);
    $neededChat = $me->select("chats", ['*'], ['uniqueKey' => $key])[0];
    $idOfNeededChat = $neededChat['id'];
    echo $idOfNeededChat;
    exit;
} elseif ($_POST['btw2users'] == 'false') {
    $allparticipant = explode(',', $_POST['ids']);
    $allparticipant[] = $me->id;
    $allparticipant = array_unique($allparticipant);
    if (count($allparticipant) == 2) {
        $chats = $me->select("chats", ['*']);
        for ($i = 0; $i < count($chats); $i++) {
            if ($chats[$i]['is_between2users'] == 'true') {
                $participantsOfChat = explode(';', $chats[$i]['participants']);
                $diff = array_diff($participantsOfChat, $allparticipant);
                if (empty($diff)) {
                    $id = $chats[$i]['id'];
                    echo $id;
                    exit;
                }
            }
        }
        $key = uniqid(bin2hex(random_bytes(10)), true) . getmypid();
        $me->insert('chats', [
            'is_between2users' => 'true',
            'uniqueKey' => $key,
            'creator' => $me->id,
            'participants' => implode(';', $allparticipant)
        ]);
        $neededChat = $me->select("chats", ['*'], ['uniqueKey' => $key])[0];
        $idOfNeededChat = $neededChat['id'];
        echo $idOfNeededChat;
        exit;
    } else {
        if (!empty($_FILES)) {
            $filePath  = $_FILES['imageOfConv']['tmp_name'];
            $errorCode = $_FILES['imageOfConv']['error'];

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

            if (!move_uploaded_file($filePath, 'd:/OpenServer/domains/data.rpg.com/userimg/chats/' . $name . $format)) {
                die('При записи изображения на диск произошла ошибка.');
            }
            $nameOfImage = $name . $format;
        } else {
            $nameOfImage = NULL;
        }

        $key = uniqid(bin2hex(random_bytes(10)), true) . getmypid();
        $me->insert('chats', [
            'is_between2users' => 'false',
            'uniqueKey' => $key,
            'image' => $nameOfImage,
            'name' => $_POST['nameOfConv'],
            'creator' => $me->id,
            'participants' => implode(';', $allparticipant)
        ]);
        $neededChat = $me->select("chats", ['*'], ['uniqueKey' => $key])[0];
        $idOfNeededChat = $neededChat['id'];
        $text = $me->firstName . ' has created conversation';
        $me->insert('messages', [
            'fromID' => 0,
            'chatID' => $idOfNeededChat,
            'text' => nl2br(trim(entities(str_replace("'", "\\'", str_replace("\\", "\\\\", $text))))),
            'time' => local2gm(time()),
            'type' => 1
        ]);
        echo $idOfNeededChat;
        exit;
    }
}
