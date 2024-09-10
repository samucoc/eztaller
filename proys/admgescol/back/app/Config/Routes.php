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

$routes->group('Api', function ($routes) {
    $routes->group('V1', function ($routes) {
        $routes->resource(
            'roles',
            [
                'controller' => 'RoleController',
                'namespace' => 'App\Controllers\Api\V1',
                'only' => [
                    'index',
                    'show',
                    'new',
                    'create',
                    'update',
                    'delete'
                ],
            ]
        );
        $routes->group('users', ['namespace' => 'App\Controllers\Api\V1'], function ($routes) {
            $routes->post('register', 'UserController::register');
            $routes->post('sign-in', 'UserController::signIn');
            $routes->post('sign-in-rut', 'UserController::signInRut');
            $routes->post('signout', 'UserController::signout');
            $routes->post('request-password-recovery', 'UserController::requestPasswordRecovery');
            $routes->post('set-new-password', 'UserController::setNewPassword');
            $routes->get('role/(:num)', 'UserController::listByRole/$1');
            $routes->get('showByRut/(:segment)', 'UserController::showByRut/$1');
        });
        
        // Resource route for users, using the same namespace
        $routes->resource('users', [
            'controller' => 'UserController',
            'namespace' => 'App\Controllers\Api\V1',
            'only' => ['index', 'show', 'new', 'create', 'update', 'delete']
        ]);
        

        $routes->get('documentos', 'DocumentoController::index', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/new', 'DocumentoController::new', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/show/(:segment)', 'DocumentoController::show/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('documentos', 'DocumentoController::create', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('documentos/firmar-doc', 'DocumentoController::firmarDoc', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/showByRut/(:segment)', 'DocumentoController::showByRut/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/showLiquidaciones/(:segment)', 'DocumentoController::showLiquidaciones/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/showReglamento/(:segment)', 'DocumentoController::showReglamento/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/showContratos/(:segment)', 'DocumentoController::showContratos/$1', ['namespace' => 'App\Controllers\Api\V1']);
 
        $routes->get('documentos/showCargaByUserByEmp/(:segment)/(:segment)', 'DocumentoController::showCargaByUserByEmp/$1/$2', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/showFunGenByUserByEmp/(:segment)/(:segment)', 'DocumentoController::showFunGenByUserByEmp/$1/$2', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/showRIOHSByUserByEmp/(:segment)/(:segment)', 'DocumentoController::showRIOHSByUserByEmp/$1/$2', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/showContratosByUserByEmp/(:segment)/(:segment)', 'DocumentoController::showContratosByUserByEmp/$1/$2', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/showLiqActByUserByEmp/(:segment)/(:segment)', 'DocumentoController::showLiqActByUserByEmp/$1/$2', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/showLiqAntByUserByEmp/(:segment)/(:segment)', 'DocumentoController::showLiqAntByUserByEmp/$1/$2', ['namespace' => 'App\Controllers\Api\V1']);
 
        $routes->get('documentos/showCargaByEmp/(:segment)', 'DocumentoController::showCargaByEmp/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/showFunGenByEmp/(:segment)', 'DocumentoController::showFunGenByEmp/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/showRIOHSByEmp/(:segment)', 'DocumentoController::showRIOHSByEmp/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/showContratosByEmp/(:segment)', 'DocumentoController::showContratosByEmp/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/showLiqActByEmp/(:segment)', 'DocumentoController::showLiqActByEmp/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/showLiqAntByEmp/(:segment)', 'DocumentoController::showLiqAntByEmp/$1', ['namespace' => 'App\Controllers\Api\V1']);
                
        $routes->post('documentos/upload', 'DocumentoController::uploadDocumento', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('documentos/upload-contratos', 'DocumentoController::uploadContratosDocumento', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('documentos/upload-varios', 'DocumentoController::uploadVariosDocumento', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->put('documentos/(:segment)', 'DocumentoController::update/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->delete('documentos/(:segment)', 'DocumentoController::delete/$1', ['namespace' => 'App\Controllers\Api\V1']);
        
        $routes->get('trabajadores', 'TrabajadorController::index', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('trabajadores/new', 'TrabajadorController::new', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('trabajadores/show/(:segment)', 'TrabajadorController::show/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('trabajadores/showByRut/(:segment)', 'TrabajadorController::showByRut/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('trabajadores/showByEmpresa/(:segment)', 'TrabajadorController::showByEmpresa/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('trabajadores', 'TrabajadorController::create', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('trabajadores/bulk-upload', 'TrabajadorController::bulkUpload', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('trabajadores/uploadFoto/(:segment)', 'TrabajadorController::uploadFoto/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->put('trabajadores/(:segment)', 'TrabajadorController::update/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->delete('trabajadores/(:segment)', 'TrabajadorController::delete/$1', ['namespace' => 'App\Controllers\Api\V1']);
        
        $routes->get('TrabajadoresTienenDocumentos', 'TrabajadoresTienenDocumentosController::index', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('TrabajadoresTienenDocumentos/new', 'TrabajadoresTienenDocumentosController::new', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('TrabajadoresTienenDocumentos/show/(:segment)', 'TrabajadoresTienenDocumentosController::show/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('TrabajadoresTienenDocumentos', 'TrabajadoresTienenDocumentosController::create', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->put('TrabajadoresTienenDocumentos/(:segment)', 'TrabajadoresTienenDocumentosController::update/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->delete('TrabajadoresTienenDocumentos/(:segment)', 'TrabajadoresTienenDocumentosController::delete/$1', ['namespace' => 'App\Controllers\Api\V1']);
                
        $routes->get('cargos', 'CargoController::index', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('cargos/new', 'CargoController::new', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('cargos/show/(:segment)', 'CargoController::show/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('cargos', 'CargoController::create', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->put('cargos/(:segment)', 'CargoController::update/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->delete('cargos/(:segment)', 'CargoController::delete/$1', ['namespace' => 'App\Controllers\Api\V1']);
        
        $routes->get('comunas', 'ComunaController::index', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('comunas/new', 'ComunaController::new', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('comunas/show/(:segment)', 'ComunaController::show/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('comunas', 'ComunaController::create', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->put('comunas/(:segment)', 'ComunaController::update/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->delete('comunas/(:segment)', 'ComunaController::delete/$1', ['namespace' => 'App\Controllers\Api\V1']);
                
        $routes->get('empresas', 'EmpresaController::index', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('empresas/new', 'EmpresaController::new', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('empresas/show/(:segment)', 'EmpresaController::show/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('empresas', 'EmpresaController::create', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->put('empresas/(:segment)', 'EmpresaController::update/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->delete('empresas/(:segment)', 'EmpresaController::delete/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('empresas/trabajadores/(:segment)', 'EmpresaController::showByRut/$1', ['namespace' => 'App\Controllers\Api\V1']);
        
        $routes->get('sexo', 'SexoController::index', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('sexo/new', 'SexoController::new', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('sexo/show/(:segment)', 'SexoController::show/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('sexo', 'SexoController::create', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->put('sexo/(:segment)', 'SexoController::update/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->delete('sexo/(:segment)', 'SexoController::delete/$1', ['namespace' => 'App\Controllers\Api\V1']);
        
        $routes->get('tipo_doc', 'Tipo_DocController::index', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('tipo_doc/new', 'Tipo_DocController::new', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('tipo_doc/show/(:segment)', 'Tipo_DocController::show/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('tipo_doc', 'Tipo_DocController::create', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->put('tipo_doc/(:segment)', 'Tipo_DocController::update/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->delete('tipo_doc/(:segment)', 'Tipo_DocController::delete/$1', ['namespace' => 'App\Controllers\Api\V1']);

        $routes->get('tipoSol', 'TipoSolController::index', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('tipoSol/new', 'TipoSolController::new', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('tipoSol/show/(:segment)', 'TipoSolController::show/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('tipoSol', 'TipoSolController::create', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->put('tipoSol/(:segment)', 'TipoSolController::update/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->delete('tipoSol/(:segment)', 'TipoSolController::delete/$1', ['namespace' => 'App\Controllers\Api\V1']);

        $routes->get('estadoSol', 'EstadoSolController::index', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('estadoSol/new', 'EstadoSolController::new', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('estadoSol/show/(:segment)', 'EstadoSolController::show/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('estadoSol', 'EstadoSolController::create', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->put('estadoSol/(:segment)', 'EstadoSolController::update/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->delete('estadoSol/(:segment)', 'EstadoSolController::delete/$1', ['namespace' => 'App\Controllers\Api\V1']);

        $routes->get('notificaciones', 'NotificacionController::index', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('notificaciones/new', 'NotificacionController::new', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('notificaciones/show/(:segment)', 'NotificacionController::show/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('notificaciones', 'NotificacionController::create', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->put('notificaciones/(:segment)', 'NotificacionController::update/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->delete('notificaciones/(:segment)', 'NotificacionController::delete/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('notificaciones/notificaciones-marcadas/(:segment)', 'NotificacionController::marcarComoVistas/$1', ['namespace' => 'App\Controllers\Api\V1']);
        
        $routes->get('solicitudes', 'SolicitudController::index', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('solicitudes/new', 'SolicitudController::new', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('solicitudes/show/(:segment)', 'SolicitudController::show/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('solicitudes', 'SolicitudController::create', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->put('solicitudes/(:segment)', 'SolicitudController::update/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->delete('solicitudes/(:segment)', 'SolicitudController::delete/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('solicitudes/change-status/(:num)/(:num)', 'SolicitudController::changeStatus/$1/$2', ['namespace' => 'App\Controllers\Api\V1']);

        $routes->get('comunicaciones', 'ComunicacionController::index', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('comunicaciones/new', 'ComunicacionController::new', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('comunicaciones/show/(:segment)', 'ComunicacionController::show/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('comunicaciones', 'ComunicacionController::create', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->put('comunicaciones/(:segment)', 'ComunicacionController::update/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->delete('comunicaciones/(:segment)', 'ComunicacionController::delete/$1', ['namespace' => 'App\Controllers\Api\V1']);
        
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
