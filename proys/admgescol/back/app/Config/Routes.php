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
        $routes->group('users', function ($routes) {
            $routes->post(
                'register',
                'UserController::register',
                [
                    'namespace' => implode(
                        '',
                        [
                            $routes->getDefaultNamespace(),
                            'Api\V1'
                        ]
                    )
                ]
            );
            $routes->post(
                'sign-in',
                'UserController::signIn',
                [
                    'namespace' => implode(
                        '',
                        [
                            $routes->getDefaultNamespace(),
                            'Api\V1'
                        ]
                    )
                ]
            );
            $routes->post(
                'signout',
                'UserController::signout',
                [
                    'namespace' => implode(
                        '',
                        [
                            $routes->getDefaultNamespace(),
                            'Api\V1'
                        ]
                    )
                ]
            );
            $routes->post(
                'request-password-recovery',
                'UserController::requestPasswordRecovery',
                [
                    'namespace' => implode(
                        '',
                        [
                            $routes->getDefaultNamespace(),
                            'Api\V1'
                        ]
                    )
                ]
            );
            $routes->post(
                'set-new-password',
                'UserController::setNewPassword',
                [
                    'namespace' => implode(
                        '',
                        [
                            $routes->getDefaultNamespace(),
                            'Api\V1'
                        ]
                    )
                ]
            );
            $routes->get(
                'role/(:num)',
                'UserController::listByRole/$1',
                [
                    'namespace' => implode(
                        '',
                        [
                            $routes->getDefaultNamespace(),
                            'Api\V1'
                        ]
                    )
                ]
            );
        });
        $routes->resource(
            'users',
            [
                'controller' => 'UserController',
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

        $routes->get('documentos', 'DocumentoController::index', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/new', 'DocumentoController::new', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/show/(:segment)', 'DocumentoController::show/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('documentos', 'DocumentoController::create', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/showByRut/(:segment)', 'DocumentoController::showByRut/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/showLiquidaciones/(:segment)', 'DocumentoController::showLiquidaciones/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/showReglamento/(:segment)', 'DocumentoController::showReglamento/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('documentos/showContratos/(:segment)', 'DocumentoController::showContratos/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('documentos/upload', 'DocumentoController::uploadDocumento', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->put('documentos/(:segment)', 'DocumentoController::update/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->delete('documentos/(:segment)', 'DocumentoController::delete/$1', ['namespace' => 'App\Controllers\Api\V1']);
        
        $routes->get('trabajadores', 'TrabajadorController::index', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('trabajadores/new', 'TrabajadorController::new', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('trabajadores/show/(:segment)', 'TrabajadorController::show/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('trabajadores/showByRut/(:segment)', 'TrabajadorController::showByRut/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->get('trabajadores/showByEmpresa/(:segment)', 'TrabajadorController::showByEmpresa/$1', ['namespace' => 'App\Controllers\Api\V1']);
        $routes->post('trabajadores', 'TrabajadorController::create', ['namespace' => 'App\Controllers\Api\V1']);
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
