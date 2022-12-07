<?php

require_once '../bootstrap/base-paths.php';
require_once '../vendor/autoload.php';

use core\application\Application;

$app = new Application();
$app->run();
