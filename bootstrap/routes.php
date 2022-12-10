<?php

use core\controllers\AppController;
use core\controllers\login\LoginController;
use core\controllers\register\RegisterController;
use core\controllers\admins\AdminsController;

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

    'register' => [
        'controller' => RegisterController::class,
        'action' => 'index',
        'method' => 'GET'
    ],

    'admins' => [
        'controller' => AdminsController::class,
        'action' => 'show',
        'method' => 'GET'
    ],

    'admins/delete' => [
        'controller' => AdminsController::class,
        'action' => 'delete',
        'method' => 'DELETE'
    ],

    'admins/edit' => [
        'controller' => AdminsController::class,
        'action' => 'edit',
        'method' => 'GET'
    ],

    'admins/create' => [
        'controller' => AdminsController::class,
        'action' => 'create',
        'method' => 'POST'
    ]
];
