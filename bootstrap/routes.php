<?php

use core\controllers\AppController;
use core\controllers\login\LoginController;

return [
    '' => [
        'controller' => AppController::class,
        'action' => 'index',
        'method' => 'GET'
    ],

    'login' => [
        'controller' => LoginController::class,
        'action' => 'index',
        'method' => 'GET'
    ]
];
