<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->post('login', 'AuthController::login');
    // Outras rotas, por exemplo, para usuários, produtos, etc.
});