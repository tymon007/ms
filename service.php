<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=apka', 'root', 'root');
} catch (PDOException $e) {
    print "Ошибка соединеия!: " . $e->getMessage();
    exit;
}
