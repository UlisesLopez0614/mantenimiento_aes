<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('contenido.contenido');
})->name('main');

//Route::get('/', 'Auth\LoginController@showLoginForm')->name('principal');
//Route::post('/login', 'Auth\LoginController@login')->name('login');
//Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/roles', 'RolController@index');
Route::get('/roles/selectRol', 'RolController@selectRol');

Route::get('/talleres', 'TallerController@index');
Route::get('/talleres/selectTaller', 'TallerController@selectTaller');
Route::post('/talleres/registrar', 'TallerController@store');
Route::put('/talleres/actualizar', 'TallerController@update');
Route::put('/talleres/desactivar', 'TallerController@desactivar');
Route::put('/talleres/activar', 'TallerController@activar');

Route::get('/tipomantos', 'TipomantoController@index');
Route::get('/tipomantos/selectTipomanto', 'TipomantoController@selectTipomanto');
Route::get('/tipomantos/info', 'TipomantoController@info');
Route::post('/tipomantos/registrar', 'TipomantoController@store');
Route::put('/tipomantos/actualizar', 'TipomantoController@update');
Route::put('/tipomantos/desactivar', 'TipomantoController@desactivar');
Route::put('/tipomantos/activar', 'TipomantoController@activar');

Route::get('/principales', 'PrincipalController@index');
Route::get('/mantenimientos', 'MantenimientoController@index');
Route::post('/mantenimientos/registrar', 'MantenimientoController@store');

Route::get('/vehiculos/historial', 'MantenimientoController@refrescarOdometro');
