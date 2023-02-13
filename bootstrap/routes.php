<?php

use core\controllers\AppController;
use core\controllers\login\LoginController;
use core\controllers\register\RegisterController;
use core\controllers\admins\AdminsController;
use core\controllers\countries\CountriesController;
use core\controllers\resorts\ResortsController;
use core\controllers\hotels\HotelsController;
use core\controllers\buses\BusesController;
use core\controllers\periods\PeriodsController;
use core\controllers\managers\ManagersController;
use core\controllers\rooms\RoomsController;
use core\controllers\clients\ClientsController;
use core\controllers\tours\ToursController;
use core\controllers\contracts\ContractsController;
use core\controllers\currencies\CurrenciesController;
use core\controllers\net\NetController;


return [
    'admin' => [
        'controller' => AppController::class,
        'action' => 'main',
        'method' => 'GET'
    ],

    'admin/dashboard' => [
        'controller' => AppController::class,
        'action' => 'dashboard',
        'method' => 'GET'
    ],

    '' => [
        'controller' => AppController::class,
        'action' => 'tours_new',
        'method' => 'GET'
    ],

    'login' => [
        'controller' => LoginController::class,
        'action' => 'form',
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
        'action' => 'form',
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

    'resorts/update' => [
        'controller' => ResortsController::class,
        'action' => 'update',
        'method' => 'PUT'
    ],

    'resorts/delete' => [
        'controller' => ResortsController::class,
        'action' => 'delete',
        'method' => 'DELETE'
    ],

    'hotels/new' => [
        'controller' => HotelsController::class,
        'action' => 'new',
        'method' => 'GET'
    ],

    'hotels' => [
        'controller' => HotelsController::class,
        'action' => 'read',
        'method' => 'GET'
    ],

    'hotels/edit' => [
        'controller' => HotelsController::class,
        'action' => 'edit',
        'method' => 'GET'
    ],

    'hotels/create' => [
        'controller' => HotelsController::class,
        'action' => 'create',
        'method' => 'POST'
    ],

    'hotels/update' => [
        'controller' => HotelsController::class,
        'action' => 'update',
        'method' => 'PUT'
    ],

    'hotels/delete' => [
        'controller' => HotelsController::class,
        'action' => 'delete',
        'method' => 'DELETE'
    ],

    'buses/new' => [
        'controller' => BusesController::class,
        'action' => 'new',
        'method' => 'GET'
    ],

    'buses/readOne' => [
        'controller' => BusesController::class,
        'action' => 'readOne',
        'method' => 'GET'
    ],

    'buses' => [
        'controller' => BusesController::class,
        'action' => 'read',
        'method' => 'GET'
    ],

    'busesOne' => [
        'controller' => BusesController::class,
        'action' => 'readOne',
        'method' => 'GET'
    ],

    'buses/edit' => [
        'controller' => BusesController::class,
        'action' => 'edit',
        'method' => 'GET'
    ],

    'buses/create' => [
        'controller' => BusesController::class,
        'action' => 'create',
        'method' => 'POST'
    ],

    'buses/update' => [
        'controller' => BusesController::class,
        'action' => 'update',
        'method' => 'PUT'
    ],

    'buses/delete' => [
        'controller' => BusesController::class,
        'action' => 'delete',
        'method' => 'DELETE'
    ],

    'periods/new' => [
        'controller' => PeriodsController::class,
        'action' => 'new',
        'method' => 'GET'
    ],

    'periods' => [
        'controller' => PeriodsController::class,
        'action' => 'read',
        'method' => 'GET'
    ],

    'periods/edit' => [
        'controller' => PeriodsController::class,
        'action' => 'edit',
        'method' => 'GET'
    ],

    'periods/create' => [
        'controller' => PeriodsController::class,
        'action' => 'create',
        'method' => 'POST'
    ],

    'periods/update' => [
        'controller' => PeriodsController::class,
        'action' => 'update',
        'method' => 'PATCH'
    ],

    'periods/delete' => [
        'controller' => PeriodsController::class,
        'action' => 'delete',
        'method' => 'DELETE'
    ],

    'managers/new' => [
        'controller' => ManagersController::class,
        'action' => 'new',
        'method' => 'GET'
    ],

    'managers' => [
        'controller' => ManagersController::class,
        'action' => 'read',
        'method' => 'GET'
    ],

    'managers/edit' => [
        'controller' => ManagersController::class,
        'action' => 'edit',
        'method' => 'GET'
    ],

    'managers/create' => [
        'controller' => ManagersController::class,
        'action' => 'create',
        'method' => 'POST'
    ],

    'managers/update' => [
        'controller' => ManagersController::class,
        'action' => 'update',
        'method' => 'PUT'
    ],

    'managers/delete' => [
        'controller' => ManagersController::class,
        'action' => 'delete',
        'method' => 'DELETE'
    ],

    'rooms/pickHotel' => [
        'controller' => RoomsController::class,
        'action' => 'pickHotel',
        'method' => 'GET'
    ],

    'rooms/new' => [
        'controller' => RoomsController::class,
        'action' => 'new',
        'method' => 'GET'
    ],

    'rooms' => [
        'controller' => RoomsController::class,
        'action' => 'read',
        'method' => 'GET'
    ],

    'roomsOne' => [
        'controller' => RoomsController::class,
        'action' => 'readOne',
        'method' => 'GET'
    ],

    'rooms/edit' => [
        'controller' => RoomsController::class,
        'action' => 'edit',
        'method' => 'GET'
    ],

    'rooms/create' => [
        'controller' => RoomsController::class,
        'action' => 'create',
        'method' => 'POST'
    ],

    'rooms/update' => [
        'controller' => RoomsController::class,
        'action' => 'update',
        'method' => 'PUT'
    ],

    'rooms/delete' => [
        'controller' => RoomsController::class,
        'action' => 'delete',
        'method' => 'DELETE'
    ],

    'clients' => [
        'controller' => ClientsController::class,
        'action' => 'read',
        'method' => 'GET'
    ],

    'clients/find' => [
        'controller' => ClientsController::class,
        'action' => 'find',
        'method' => 'POST'
    ],

    'clients/last' => [
        'controller' => ClientsController::class,
        'action' => 'getLastClientId',
        'method' => 'POST'
    ],

    'clients/edit' => [
        'controller' => ClientsController::class,
        'action' => 'edit',
        'method' => 'GET'
    ],

    'clients/create' => [
        'controller' => ClientsController::class,
        'action' => 'create',
        'method' => 'POST'
    ],

    'clients/updateSubClients' => [
        'controller' => ClientsController::class,
        'action' => 'updateSubClients',
        'method' => 'PUT'
    ],

    'clients/update' => [
        'controller' => ClientsController::class,
        'action' => 'update',
        'method' => 'PUT'
    ],

    'clients/delete' => [
        'controller' => ClientsController::class,
        'action' => 'delete',
        'method' => 'DELETE'
    ],

    'clients/new' => [
        'controller' => ClientsController::class,
        'action' => 'new',
        'method' => 'GET'
    ],

    'clients/passengers' => [
        'controller' => ClientsController::class,
        'action' => 'passengers',
        'method' => 'GET'
    ],

    'clients/list' => [
        'controller' => ClientsController::class,
        'action' => 'list',
        'method' => 'POST'
    ],

    'tours' => [
        'controller' => ToursController::class,
        'action' => 'read',
        'method' => 'GET'
    ],

    'tours/count' => [
        'controller' => ToursController::class,
        'action' => 'count',
        'method' => 'POST'
    ],

    'tours/search' => [
        'controller' => ToursController::class,
        'action' => 'search',
        'method' => 'GET'
    ],

    'tours/countPlacesBack' => [
        'controller' => ToursController::class,
        'action' => 'countPlacesBack',
        'method' => 'POST'
    ],

    'tours/edit' => [
        'controller' => ToursController::class,
        'action' => 'edit',
        'method' => 'GET'
    ],

    'tours/create' => [
        'controller' => ToursController::class,
        'action' => 'create',
        'method' => 'POST'
    ],

    'tours/update' => [
        'controller' => ToursController::class,
        'action' => 'update',
        'method' => 'PUT'
    ],

    'tours/delete' => [
        'controller' => ToursController::class,
        'action' => 'delete',
        'method' => 'DELETE'
    ],

    'tours/printVoucher' => [
        'controller' => ToursController::class,
        'action' => 'printVoucher',
        'method' => 'GET'
    ],

    'tours/new' => [
        'controller' => ToursController::class,
        'action' => 'new',
        'method' => 'GET'
    ],

    'tours/printContract' => [
        'controller' => ToursController::class,
        'action' => 'printContract',
        'method' => 'GET'
    ],

    'tours/printAttachmentTwo' => [
        'controller' => ToursController::class,
        'action' => 'printAttachmentTwo',
        'method' => 'GET'
    ],

    'contracts' => [
        'controller' => ContractsController::class,
        'action' => 'read',
        'method' => 'GET'
    ],

    'contracts/addLabel' => [
        'controller' => ContractsController::class,
        'action' => 'addLabel',
        'method' => 'POST'
    ],

    'contracts/new' => [
        'controller' => ContractsController::class,
        'action' => 'new',
        'method' => 'GET'
    ],

    'contracts/create' => [
        'controller' => ContractsController::class,
        'action' => 'create',
        'method' => 'POST'
    ],

    'contracts/update' => [
        'controller' => ContractsController::class,
        'action' => 'update',
        'method' => 'PUT'
    ],

    'contracts/edit' => [
        'controller' => ContractsController::class,
        'action' => 'edit',
        'method' => 'GET'
    ],

    'contracts/delete' => [
        'controller' => ContractsController::class,
        'action' => 'delete',
        'method' => 'DELETE'
    ],

    'passengers_list' => [
        'controller' => ClientsController::class,
        'action' => 'passengers_list',
        'method' => 'GET'
    ],

    'rooms/free' => [
        'controller' => RoomsController::class,
        'action' => 'free',
        'method' => 'GET'
    ],

    'currencies' => [
        'controller' => CurrenciesController::class,
        'action' => 'read',
        'method' => 'GET'
    ],

    'currencies/new' => [
        'controller' => CurrenciesController::class,
        'action' => 'new',
        'method' => 'GET'
    ],

    'currencies/create' => [
        'controller' => CurrenciesController::class,
        'action' => 'create',
        'method' => 'POST'
    ],

    'net' => [
        'controller' => NetController::class,
        'action' => 'read',
        'method' => 'GET'
    ]
];
