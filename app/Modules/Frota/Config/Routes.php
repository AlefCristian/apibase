<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->group('api/frota', ['namespace' => 'Modules\Frota\Controllers'], function ($routes) {
    $routes->post('saida', 'FrotaController::create');
    $routes->put('retorno/(:num)', 'FrotaController::registrarRetorno/$1');
    $routes->get('lista', 'FrotaController::getUltimaSaidaSemRetorno');
});
