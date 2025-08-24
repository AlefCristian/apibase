<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->group('api/frota', ['namespace' => 'Frota\Controllers'], function ($routes) {
    $routes->post('saida', 'FrotaController::create');
    $routes->put('retorno/(:num)', 'FrotaController::registrarRetorno/$1');
    $routes->get('lista', 'FrotaController::getUltimaSaidaSemRetorno');
    $routes->get('teste', 'FrotaController::teste');
});