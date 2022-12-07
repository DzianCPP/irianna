<?php

use core\controllers\AppController;
use core\controllers\buses\BusesController;

return [
    '' => [
        'controller' => AppController::class,
        'action' => 'index',
        'method' => 'GET'
    ],

    'buses/create' => [
        'controller' => BusesController::class,
        'action' => 'create',
        'method' => 'POST'
    ],

    'buses' => [
        'controller' => BusesController::class,
        'action' => 'read',
        'method' => 'GET'
    ],

    'buses/delete' => [
        'controller' => BusesController::class,
        'action' => 'delete',
        'method' => 'DELETE'
    ],

    'buses/update' => [
        'controller' => BusesController::class,
        'action' => 'update',
        'method' => 'PUT'
    ]
];
