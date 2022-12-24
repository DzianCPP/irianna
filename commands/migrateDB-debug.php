
<?php

require_once __DIR__ . '/../bootstrap/base-paths.php';
require_once BASE_PATH . 'vendor/autoload.php';

use system\MigrationsHandler;

$migrations = new MigrationsHandler();
$migrations->run();
