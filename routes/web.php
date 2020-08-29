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
});

Auth::routes();

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
Route::get('/tipomantos/selectTaller', 'TipomantoController@selectTaller');
Route::post('/tipomantos/registrar', 'TipomantoController@store');
Route::put('/tipomantos/actualizar', 'TipomantoController@update');
Route::put('/tipomantos/desactivar', 'TipomantoController@desactivar');
Route::put('/tipomantos/activar', 'TipomantoController@activar');
