<?php

use core\controllers\AppController;
use core\controllers\login\LoginController;
use core\controllers\register\RegisterController;
use core\controllers\admins\AdminsController;
use core\controllers\countries\CountriesController;
use core\controllers\resorts\ResortsController;

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
        'action' => 'read',
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
        'action' => 'read',
        'method' => 'GET'
    ],

    'countries/new' => [
        'controller' => CountriesController::class,
        'action' => 'new',
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
    ],

    'resorts/new' => [
        'controller' => ResortsController::class,
        'action' => 'new',
        'method' => 'GET'
    ],

    'resorts' => [
        'controller' => ResortsController::class,
        'action' => 'read',
        'method' => 'GET'
    ],

    'resorts/edit' => [
        'controller' => ResortsController::class,
        'action' => 'edit',
        'method' => 'GET'
    ],

    'resorts/create' => [
        'controller' => ResortsController::class,
        'action' => 'create',
        'method' => 'POST'
    ],

    'resort/update' => [
        'controller' => ResortsController::class,
        'action' => 'update',
        'method' => 'PATCH'
    ],

    'resorts/delete' => [
        'controller' => ResortsController::class,
        'action' => 'delete',
        'method' => 'DELETE'
    ]
];
