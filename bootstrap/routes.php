<?php

use core\controllers\AppController;
use core\controllers\login\LoginController;
use core\controllers\register\RegisterController;

return [
    'admin' => [
        'controller' => AppController::class,
        'action' => 'index',
        'method' => 'GET'
    ],

    '' => [
        'controller' => AppController::class,
        'action' => 'index',
        'method' => 'GET'
    ],

    'login' => [
        'controller' => LoginController::class,
        'action' => 'index',
        'method' => 'GET'
    ],

    'login/login' => [
        'controller' => LoginController::class,
        'action' => 'login',
        'method' => 'POST'
    ],

    'login/logout' => [
        'controller' => LoginController::class,
        'action' => 'logout',
        'method' => 'POST'
    ],

    'registration' => [
        'controller' => RegisterController::class,
        'action' => 'index',
        'method' => 'GET'
    ],

    'register' => [
        'controller' => RegisterController::class,
        'action' => 'register',
        'method' => 'POST'
    ]
];
