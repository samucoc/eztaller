<?php

use Illuminate\Http\Request;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api'

], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('user-profile', 'AuthController@userProfile');

    Route::get('programas', 'ProgramasController@index');
    Route::get('programas/{id}', 'ProgramasController@show');
    Route::post('programas', 'ProgramasController@store');
    Route::put('programas/{id}', 'ProgramasController@update');
    Route::delete('programas/{id}', 'ProgramasController@destroy');

    Route::get('ofertas', 'OfertasController@index');
    Route::get('ofertas/{id}', 'OfertasController@show');
    Route::post('ofertas', 'OfertasController@store');
    Route::put('ofertas/{id}', 'OfertasController@update');
    Route::delete('ofertas/{id}', 'OfertasController@destroy');

    Route::get('ofertasdpa', 'OfertasDpasController@index');
    Route::get('ofertasdpa/{id}', 'OfertasDpasController@show');
    Route::post('ofertasdpa', 'OfertasDpasController@store');
    Route::put('ofertasdpa/{id}', 'OfertasDpasController@update');
    Route::delete('ofertasdpa/{id}', 'OfertasDpasController@destroy');

    Route::get('dpa', 'DpaController@index');
    Route::get('dpa/{id}', 'DpaController@show');
    Route::post('dpa', 'DpaController@store');
    Route::put('dpa/{id}', 'DpaController@update');
    Route::delete('dpa/{id}', 'DpaController@destroy');
});