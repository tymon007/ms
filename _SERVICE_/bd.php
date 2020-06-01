<?php
try {
    $db = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE, DBUSER, DBPASSWORD);
} catch (PDOException $e) {
    print "Ошибка соединеия!: " . $e->getMessage();
    exit;
}
