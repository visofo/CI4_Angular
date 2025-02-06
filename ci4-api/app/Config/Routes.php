<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// $routes->group('api', ['namespace' => 'App\Controllers'], function($routes) {
//     $routes->post('login', 'AuthController::login');
//     // Outras rotas, por exemplo, para usuários, produtos, etc.
// });

$routes->group('api', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('users', 'UserController::index');
    $routes->post('users', 'UserController::create');
    $routes->get('users/(:num)', 'UserController::show/$1');
    $routes->put('users/(:num)', 'UserController::update/$1');
    $routes->delete('users/(:num)', 'UserController::delete/$1');
    $routes->get('test', 'Test::index');
});

$routes->post('auth/login', 'AuthController::login');
$routes->post('auth/register', 'AuthController::register');