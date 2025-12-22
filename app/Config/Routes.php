<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//Api Auth
$routes->post('api/register', 'Auth::register');
$routes->post('api/login', 'Auth::login');
$routes->get('api/user', 'User::profile');
$routes->get('api/menu', 'MenuController::index');
// Client Controller
$routes->get('api/clientes', 'ClientController::index');
$routes->get('api/clientes/lista', 'ClientController::read');
$routes->post('api/clientes', 'ClientController::create');
$routes->put('api/clientes/(:num)', 'ClientController::update/$1');
$routes->delete('api/clientes/(:num)', 'ClientController::delete/$1');
// Para funcionar o Cors
$routes->options('api/(:any)', static function () {}); //Pra funcionar o cors

if (file_exists(APPPATH . 'Modules/Frota/Config/Routes.php')) {
    require APPPATH . 'Modules/Frota/Config/Routes.php';
}