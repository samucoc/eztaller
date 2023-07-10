<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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

// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/Home', 'Home::index');

// Rutas personalizadas para la API
$routes->get('/Salas', 'Api\V1\SalasController::index');
$routes->get('/Salas/(:num)', 'Api\V1\SalasController::show');
$routes->post('/Salas', 'Api\V1\SalasController::create');
$routes->put('/Salas/(:num)', 'Api\V1\SalasController::update');
$routes->delete('/Salas/(:num)', 'Api\V1\SalasController::delete');

$routes->get('/asignaciones', 'Api\V1\AsignacionesController::index');
$routes->get('/asignaciones/(:num)', 'Api\V1\AsignacionesController::show');
$routes->post('/asignaciones', 'Api\V1\AsignacionesController::create');
$routes->put('/asignaciones/(:num)', 'Api\V1\AsignacionesController::update');
$routes->delete('/asignaciones/(:num)', 'Api\V1\AsignacionesController::delete');
$routes->get('/asignaciones/calendarizar/(:num)/(:num)', 'Api\V1\AsignacionesController::calendarizar/$1/$2');

$routes->get('/detallesguia', 'Api\V1\DetallesGuiaController::index');
$routes->get('/detallesguia/(:num)', 'Api\V1\DetallesGuiaController::show');
$routes->post('/detallesguia', 'Api\V1\DetallesGuiaController::create');
$routes->put('/detallesguia/(:num)', 'Api\V1\DetallesGuiaController::update');
$routes->delete('/detallesguia/(:num)', 'Api\V1\DetallesGuiaController::delete');

$routes->get('/guias', 'Api\V1\GuiasController::index');
$routes->get('/guias/(:num)', 'Api\V1\GuiasController::show');
$routes->post('/guias', 'Api\V1\GuiasController::create');
$routes->put('/guias/(:num)', 'Api\V1\GuiasController::update');
$routes->delete('/guias/(:num)', 'Api\V1\GuiasController::delete');

$routes->get('/hermanos', 'Api\V1\HermanosController::index');
$routes->get('/hermanos/(:num)', 'Api\V1\HermanosController::show');
$routes->post('/hermanos', 'Api\V1\HermanosController::create');
$routes->put('/hermanos/(:num)', 'Api\V1\HermanosController::update');
$routes->delete('/hermanos/(:num)', 'Api\V1\HermanosController::delete');

$routes->get('/privilegios', 'Api\V1\PrivilegiosController::index');
$routes->get('/privilegios/(:num)', 'Api\V1\PrivilegiosController::show');
$routes->post('/privilegios', 'Api\V1\PrivilegiosController::create');
$routes->put('/privilegios/(:num)', 'Api\V1\PrivilegiosController::update');
$routes->delete('/privilegios/(:num)', 'Api\V1\PrivilegiosController::delete');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
