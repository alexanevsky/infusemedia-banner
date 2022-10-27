<?php

require_once './src/db.php';

$db = new Db();

$file = './images/banner.jpg';

try {
    $db->write($_SERVER['REMOTE_ADDR'] ?? null, $_SERVER['HTTP_USER_AGENT'] ?? null, $_SERVER['HTTP_REFERER'] ?? null);
} catch (\Exception) {
    $file = './images/error.jpg';
}

header('Content-Type: image/jpeg');
header('Content-Length: ' . filesize($file));

readfile($file);
