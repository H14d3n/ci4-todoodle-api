<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->resource('api/v1/todos', ['filter' => 'jwt']);
$routes->resource('api/v1/categories', ['filter' => 'jwt']);

$routes->post('auth/jwt', '\App\Controllers\Auth\LoginController::jwtLogin');

service('auth')->routes($routes);
