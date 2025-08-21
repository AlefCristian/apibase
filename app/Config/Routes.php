<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Api Auth
$routes->post('api/register', 'Auth::register');
$routes->post('api/login', 'Auth::login');
$routes->get('api/user', 'User::profile');

