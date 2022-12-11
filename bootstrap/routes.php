<?php

use core\controllers\AppController;
use core\controllers\login\LoginController;
use core\controllers\register\RegisterController;
use core\controllers\admins\AdminsController;
use core\controllers\countries\CountriesController;

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

    'notfound' => [
        'controller' => AppController::class,
        'action' => 'notFound',
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
    ],

    'admins/update' => [
        'controller' => AdminsController::class,
        'action' => 'update',
        'method' => 'PUT'
    ],

    'countries' => [
        'controller' => CountriesController::class,
        'action' => 'show',
        'method' => 'GET'
    ],

    'countries/delete' => [
        'controller' => CountriesController::class,
        'action' => 'delete',
        'method' => 'DELETE'
    ],

    'countries/edit' => [
        'controller' => CountriesController::class,
        'action' => 'edit',
        'method' => 'GET'
    ],

    'countries/create' => [
        'controller' => CountriesController::class,
        'action' => 'create',
        'method' => 'POST'
    ],

    'countries/update' => [
        'controller' => CountriesController::class,
        'action' => 'update',
        'method' => 'PUT'
    ]
];
