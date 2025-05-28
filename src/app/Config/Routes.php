<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/email', 'EmailController::index');

$routes->resource('api/v1/todos', ['filter' => 'check_api_key']);
$routes->resource('api/v1/categories', ['filter' => 'jwt']);

$routes->post('auth/jwt', '\App\Controllers\LoginController::jwtLogin');
service('auth')->routes($routes);
