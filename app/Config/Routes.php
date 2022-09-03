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

$routes->get('/', function(){
    session_start();
    var_dump($_SESSION);
});
$routes->group('api', function($routes) {
        $routes->post('register', 'WebController::register');
        $routes->post('login', 'WebController::login');

        //Retorna os dados do jornalista
        $routes->get('me', 'JournalistController::journalistMe', ['filter' => 'Auth']);

        // Cria um tipo de noticia
        $routes->post('type/create', 'NewsTypeController::create', ['filter' => 'Auth']);
        // Altera tipo de notícia
        $routes->put('type/update/(:num)', 'NewsTypeController::update/$1', ['filter' => 'Auth']);
        // Deleta Tipo de notícia
        $routes->delete('type/delete/(:num)', 'NewsTypeController::delete/$1', ['filter' => 'Auth']);


});



if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
