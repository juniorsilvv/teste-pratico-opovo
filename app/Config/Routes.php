<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

$routes->group('api', function ($routes) {
    // Registro de jornalista
    $routes->post('register', 'WebController::register');
    // Login de jornalista
    $routes->post('login', 'WebController::login');

    // Retorna os dados do jornalista
    $routes->get('me', 'JournalistController::journalistMe', ['filter' => 'Auth']);
    // Lista os tipos de notícia
    $routes->get('type/me', 'NewsTypeController::newsTypeMe', ['filter' => 'Auth']);
    // Cria um tipo de noticia
    $routes->post('type/create', 'NewsTypeController::create', ['filter' => 'Auth']);
    // Altera tipo de notícia
    $routes->put('type/update/(:num)', 'NewsTypeController::update/$1', ['filter' => 'Auth']);
    // Deleta Tipo de notícia
    $routes->delete('type/delete/(:num)', 'NewsTypeController::delete/$1', ['filter' => 'Auth']);

    // Lista as notícias
    $routes->get('news/me', 'NewsController::newsMe', ['filter' => 'Auth']);
    // Lista as notícias por tipo
    $routes->get('news/me/(:num)', 'NewsController::newsTypeMe/$1', ['filter' => 'Auth']);
    // Cria a notícia
    $routes->post('news/create', 'NewsController::create', ['filter' => 'Auth']);
    // Altera a notícia
    $routes->put('news/update/(:num)', 'NewsController::update/$1', ['filter' => 'Auth']);
    // Deleta Tipo de notícia
    $routes->delete('news/delete/(:num)', 'NewsController::delete/$1', ['filter' => 'Auth']);
});



if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
