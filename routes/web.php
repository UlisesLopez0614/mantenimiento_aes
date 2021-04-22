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

Route::get('/main', function () {
    return view('contenido.contenido');
})->name('main');

Route::get('/', 'Auth\LoginController@showLoginForm')->name('principal');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home_data', 'HomeController@home_data')->name('home_data');


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
//----------------------------Rutas De Los Modulos de Mantenimientos
Route::get('/baterias', 'VehicleDetailsController@getBatteryDetails');
Route::post('/baterias/registrar', 'VehicleDetailsController@registerBatteryRecord');
Route::get('/battery_records', 'VehicleDetailsController@getBatteryHistory');


Route::get('/tires', 'VehicleDetailsController@getTireDetails');
Route::post('/tires/registrar', 'VehicleDetailsController@registerTireRecord');
Route::get('/tire_records', 'VehicleDetailsController@getTireHistory');


Route::get('/lubricantes', 'VehicleDetailsController@index');
Route::get('/llantas', 'VehicleDetailsController@index');
//
Route::get('/mantenimientos', 'MantenimientoController@index');
Route::post('/mantenimientos/registrar', 'MantenimientoController@store');

Route::get('/vehiculos/historial', 'MantenimientoController@refrescarOdometro');

Route::get('/reportes/consolidado', 'ReporteriaController@consolidado');
Route::get('/reportes/consolidadoDescargar', 'ReporteriaController@consolidadoDescargar');
