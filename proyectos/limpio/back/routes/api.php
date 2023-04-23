<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => ['api'],
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});


/**
 * Rutas la administracion de usuarios
 */

Route::group([
    'middleware' => ['api'],
    'prefix' => 'admin'
], function () {
    Route::any('/', function () {
        return Abort(404);
    });
    Route::group([
        'middleware' => ['api'],
        'prefix' => 'usuarios'
    ], function () {
        Route::post('territorialidad/options', 'UsuariosController@territorialidadOptions');
        Route::post('regiones/options', 'UsuariosController@regionesOptions');
        Route::post('comunas/options', 'UsuariosController@comunasOptions');
        Route::post('list', 'UsuariosController@index');
        Route::post('/', 'UsuariosController@store');
        Route::put('{id}', 'UsuariosController@update')->where('id', '[0-9]+');
        Route::put('clave', 'UsuariosController@changePassword');
    });
    Route::group([
        'middleware' => ['api'],
        'prefix' => 'roles/options'
    ], function () {
        Route::post('/', 'RolesController@options');
    });
});

/**
 * Rutas configuraciones
 */

Route::group([
    'middleware' => ['api'],
    'prefix' => 'config'
], function () {
    Route::post('/', 'ConfiguracionesController@get');
    Route::put('/', 'ConfiguracionesController@set');
});

Route::get('estados-civiles', [EstadosCiviles::class, 'index']);
Route::group(['prefix' => 'estados-civiles'], function () {
    Route::post('add', [EstadosCiviles::class, 'add']);
    Route::get('edit/{id}', [EstadosCiviles::class, 'edit']);
    Route::post('update/{id}', [EstadosCiviles::class, 'update']);
    Route::delete('delete/{id}', [EstadosCiviles::class, 'delete']);
});

Route::get('inversionistas', [Inversionistas::class, 'index']);
Route::group(['prefix' => 'inversionistas'], function () {
    Route::post('add', [Inversionistas::class, 'add']);
    Route::get('edit/{id}', [Inversionistas::class, 'edit']);
    Route::post('update/{id}', [Inversionistas::class, 'update']);
    Route::delete('delete/{id}', [Inversionistas::class, 'delete']);
});
