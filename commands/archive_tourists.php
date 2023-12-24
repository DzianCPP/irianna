<?php

use core\application\Database;

require_once __DIR__ . '/../bootstrap/base-paths.php';
require_once BASE_PATH . 'vendor/autoload.php';

$connection = (Database::getInstance())->getConnection();

if (!$connection->exec("UPDATE clients_table SET archived = 1")) {
    echo "error: could not archive clients" . PHP_EOL;
};

if (!$connection->exec("UPDATE subclients_table SET archived = 1")) {
    echo "error: could not archive subclients" . PHP_EOL;
}

echo "haha" . PHP_EOL;
