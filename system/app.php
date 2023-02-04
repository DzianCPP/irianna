<?php

require_once '../bootstrap/base-paths.php';
require_once '../vendor/autoload.php';

use core\application\Application;
use core\services\Archiver;

$day = date('D');

if ($day == 'Thu') {
    $archiver = new Archiver();
    try {
        $archiver->archiveClient();
    } catch (ErrorException $e) {
        echo "Не получилось выполнить архивирование клиентов";
    }
}

$app = new Application();
$app->run();
