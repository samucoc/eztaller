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


// API Routes (Versioned)
$routes->group('Api', function ($routes) {
    $routes->group('V1', function ($routes) {
        
        $routes->group('token', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
            $routes->post('check-token', 'TokenController::checkToken');
        });

        // Routes for Roles
        $routes->group('roles', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
            $routes->get('all/(:segment)', 'RoleController::index/$1');
            $routes->get('show/(:num)', 'RoleController::show/$1');
            $routes->get('new', 'RoleController::new');
            $routes->post('', 'RoleController::create');
            $routes->put('(:num)', 'RoleController::update/$1');
            $routes->delete('(:num)', 'RoleController::delete/$1');
        });

        // Routes for Users
        $routes->group('users', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
            $routes->post('register', 'UserController::register');
            $routes->post('sign-in', 'UserController::signIn');
            $routes->post('sign-in-rut', 'UserController::signInRut');
            $routes->post('signout', 'UserController::signout');
            $routes->post('request-password-recovery', 'UserController::requestPasswordRecovery');
            $routes->post('set-new-password', 'UserController::setNewPassword');
            $routes->get('showByRut/(:segment)/(:segment)', 'UserController::showByRut/$1/$2');
            $routes->get('all/(:segment)', 'UserController::index/$1');
            $routes->get('show/(:num)', 'UserController::show/$1');
            $routes->get('new', 'UserController::new');
            $routes->post('', 'UserController::create');
            $routes->put('(:num)', 'UserController::update/$1');
            $routes->delete('(:num)', 'UserController::delete/$1');
        });

        // Routes for Documentos
        $routes->group('documentos', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
            $routes->get('all/(:segment)', 'DocumentoController::index/$1');
            $routes->get('new', 'DocumentoController::new');
            $routes->get('show/(:segment)', 'DocumentoController::show/$1');
            $routes->post('', 'DocumentoController::create');
            $routes->post('firmar-doc', 'DocumentoController::firmarDoc');
            $routes->get('showByRut/(:segment)', 'DocumentoController::showByRut/$1');
            $routes->get('showLiquidaciones/(:segment)', 'DocumentoController::showLiquidaciones/$1');
            $routes->get('showReglamento/(:segment)', 'DocumentoController::showReglamento/$1');
            $routes->get('showContratos/(:segment)', 'DocumentoController::showContratos/$1');
            $routes->get('showCargaByUserByEmp/(:segment)/(:segment)/(:segment)', 'DocumentoController::showCargaByUserByEmp/$1/$2/$3');
            $routes->get('showFunGenByUserByEmp/(:segment)/(:segment)', 'DocumentoController::showFunGenByUserByEmp/$1/$2');
            $routes->get('showRIOHSByUserByEmp/(:segment)/(:segment)/(:segment)', 'DocumentoController::showRIOHSByUserByEmp/$1/$2/$3');
            $routes->get('showContratosByUserByEmp/(:segment)/(:segment)/(:segment)', 'DocumentoController::showContratosByUserByEmp/$1/$2/$3');
            $routes->get('showLiqActByUserByEmp/(:segment)/(:segment)/(:segment)', 'DocumentoController::showLiqActByUserByEmp/$1/$2/$3');
            $routes->get('showLiqAntByUserByEmp/(:segment)/(:segment)', 'DocumentoController::showLiqAntByUserByEmp/$1/$2');
            $routes->post('get-token', 'DocumentoController::getToken');
            $routes->post('upload', 'DocumentoController::uploadDocumento');
            $routes->post('upload-contratos', 'DocumentoController::uploadContratosDocumento');
            $routes->post('upload-varios', 'DocumentoController::uploadVariosDocumento');
            $routes->put('(:segment)', 'DocumentoController::update/$1');
            $routes->delete('(:segment)', 'DocumentoController::delete/$1');
        });

        // Routes for Trabajadores
        $routes->group('trabajadores', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
            $routes->get('all/(:segment)', 'TrabajadorController::index/$1');
            $routes->get('new', 'TrabajadorController::new');
            $routes->get('show/(:segment)', 'TrabajadorController::show/$1');
            $routes->get('showByRut/(:segment)', 'TrabajadorController::showByRut/$1');
            $routes->get('showByEmpresa/(:segment)', 'TrabajadorController::showByEmpresa/$1');
            $routes->post('', 'TrabajadorController::create');
            $routes->post('bulk-upload', 'TrabajadorController::bulkUpload');
            $routes->post('uploadFoto/(:segment)', 'TrabajadorController::uploadFoto/$1');
            $routes->put('(:segment)', 'TrabajadorController::update/$1');
            $routes->delete('(:segment)', 'TrabajadorController::delete/$1');
        });

        // Routes for TrabajadoresTienenDocumentos
        $routes->group('trabajadores-tienen-documentos', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
            $routes->get('', 'TrabajadoresTienenDocumentosController::index');
            $routes->get('new', 'TrabajadoresTienenDocumentosController::new');
            $routes->get('show/(:segment)', 'TrabajadoresTienenDocumentosController::show/$1');
            $routes->post('', 'TrabajadoresTienenDocumentosController::create');
            $routes->put('(:segment)', 'TrabajadoresTienenDocumentosController::update/$1');
            $routes->delete('(:segment)', 'TrabajadoresTienenDocumentosController::delete/$1');
        });

        // Routes for Cargos
        $routes->group('cargos', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
            $routes->get('all/(:segment)', 'CargoController::index/$1');
            $routes->get('new', 'CargoController::new');
            $routes->get('show/(:segment)', 'CargoController::show/$1');
            $routes->post('', 'CargoController::create');
            $routes->put('(:segment)', 'CargoController::update/$1');
            $routes->delete('(:segment)', 'CargoController::delete/$1');
        });

        // Routes for Comunas
        $routes->group('comunas', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
            $routes->get('all/(:segment)', 'ComunaController::index/$1');
            $routes->get('new', 'ComunaController::new');
            $routes->get('show/(:segment)', 'ComunaController::show/$1');
            $routes->post('', 'ComunaController::create');
            $routes->put('(:segment)', 'ComunaController::update/$1');
            $routes->delete('(:segment)', 'ComunaController::delete/$1');
        });

        // Routes for Empresas
        $routes->group('empresas', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
            $routes->get('all/(:segment)', 'EmpresaController::index/$1');
            $routes->get('new', 'EmpresaController::new');
            $routes->get('show/(:segment)', 'EmpresaController::show/$1');
            $routes->post('', 'EmpresaController::create');
            $routes->put('(:segment)', 'EmpresaController::update/$1');
            $routes->delete('(:segment)', 'EmpresaController::delete/$1');
            $routes->get('trabajadores/(:segment)', 'EmpresaController::showByRut/$1');
        });

        // Routes for Sexo
        $routes->group('sexo', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
            $routes->get('all/(:segment)', 'SexoController::index/$1');
            $routes->get('new', 'SexoController::new');
            $routes->get('show/(:segment)', 'SexoController::show/$1');
            $routes->post('', 'SexoController::create');
            $routes->put('(:segment)', 'SexoController::update/$1');
            $routes->delete('(:segment)', 'SexoController::delete/$1');
        });

        // Routes for TipoDoc
        $routes->group('tipo_doc', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
            $routes->get('all/(:segment)', 'Tipo_DocController::index/$1');
            $routes->get('new', 'Tipo_DocController::new');
            $routes->get('show/(:segment)', 'Tipo_DocController::show/$1');
            $routes->post('', 'Tipo_DocController::create');
            $routes->put('(:segment)', 'Tipo_DocController::update/$1');
            $routes->delete('(:segment)', 'Tipo_DocController::delete/$1');
        });

        // Routes for TipoSol
        $routes->group('tipoSol', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
            $routes->get('all/(:segment)', 'TipoSolController::index/$1');
            $routes->get('new', 'TipoSolController::new');
            $routes->get('show/(:segment)', 'TipoSolController::show/$1');
            $routes->post('', 'TipoSolController::create');
            $routes->put('(:segment)', 'TipoSolController::update/$1');
            $routes->delete('(:segment)', 'TipoSolController::delete/$1');
        });

        // Routes for EstadoSol
        $routes->group('estadoSol', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
            $routes->get('all/(:segment)', 'EstadoSolController::index/$1');
            $routes->get('new', 'EstadoSolController::new');
            $routes->get('show/(:segment)', 'EstadoSolController::show/$1');
            $routes->post('', 'EstadoSolController::create');
            $routes->put('(:segment)', 'EstadoSolController::update/$1');
            $routes->delete('(:segment)', 'EstadoSolController::delete/$1');
        });

        // Routes for Notificaciones
        $routes->group('notificaciones', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
            $routes->get('all/(:segment)', 'NotificacionController::index/$1');
            $routes->get('new', 'NotificacionController::new');
            $routes->get('show/(:segment)', 'NotificacionController::show/$1');
            $routes->post('', 'NotificacionController::create');
            $routes->put('(:segment)', 'NotificacionController::update/$1');
            $routes->delete('(:segment)', 'NotificacionController::delete/$1');
            $routes->get('notificaciones-marcadas/(:segment)', 'NotificacionController::marcarComoVistas/$1');
        });

        // Routes for Solicitudes
        $routes->group('solicitudes', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
            $routes->get('all/(:segment)', 'SolicitudController::index/$1');
            $routes->get('new', 'SolicitudController::new');
            $routes->get('show/(:segment)', 'SolicitudController::show/$1');
            $routes->post('', 'SolicitudController::create');
            $routes->put('(:segment)', 'SolicitudController::update/$1');
            $routes->delete('(:segment)', 'SolicitudController::delete/$1');
            $routes->post('change-status/(:num)/(:num)', 'SolicitudController::changeStatus/$1/$2');
        });

        // Routes for Comunicaciones
        $routes->group('comunicaciones', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
            $routes->get('all/(:segment)', 'ComunicacionController::index/$1');
            $routes->get('new', 'ComunicacionController::new');
            $routes->get('show/(:segment)', 'ComunicacionController::show/$1');
            $routes->post('', 'ComunicacionController::create');
            $routes->put('(:segment)', 'ComunicacionController::update/$1');
            $routes->delete('(:segment)', 'ComunicacionController::delete/$1');
        });

        // Routes for Denuncias
        $routes->group('denuncias-karin', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
            $routes->get('all/(:segment)', 'DenunciaController::index/$1');
            $routes->get('new', 'DenunciaController::new');
            $routes->get('show/(:segment)', 'DenunciaController::show/$1');
            $routes->post('', 'DenunciaController::create');
            $routes->put('(:segment)', 'DenunciaController::update/$1');
            $routes->delete('(:segment)', 'DenunciaController::delete/$1');
        });
    });
});
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
