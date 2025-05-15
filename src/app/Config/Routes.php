<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->resource('api/v1/todos', ['filter' => 'check_api_key']);
$routes->resource('api/v1/categories', ['filter' => 'check_api_key']);

$routes->post('auth/jwt', '\App\Controllers\Auth\LoginController::jwtLogin');

service('auth')->routes($routes);
