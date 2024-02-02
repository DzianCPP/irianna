<?php

require_once __DIR__ . '/../bootstrap/base-paths.php';
require_once BASE_PATH . 'vendor/autoload.php';

use system\MigrationsHandler;

$dbVersion = getopt("v:");

$migrations = new MigrationsHandler();

if (array_key_exists("v", $dbVersion)) {
    $migrations->run($dbVersion["v"]);
} else {
    $migrations->run();
}
