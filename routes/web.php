<?php

use Faker\Provider\Base;
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


Route::middleware(['admins'])->group(function () {
    Route::get('/main', function () {
        return view('contenido.contenido');
    })->name('main');

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

    //Aceites
    Route::prefix('oil')->group(function () {
        Route::get('/', 'VehicleDetailsController@getOilDetails');
        Route::post('/register','VehicleDetailsController@registerOilRecord');
        Route::post('/update','VehicleDetailsController@updateOilRecord');
        Route::get('/records', 'VehicleDetailsController@getOilHistory');
    });
//
    Route::get('/mantenimientos', 'MantenimientoController@index');
    Route::post('/mantenimientos/registrar', 'MantenimientoController@store');

    Route::get('/vehiculos/historial', 'MantenimientoController@refrescarOdometro');

    Route::get('/reportes/consolidado', 'ReporteriaController@consolidado');
    Route::get('/reportes/consolidadoDescargar', 'ReporteriaController@consolidadoDescargar');

    /*Prueba*/
    Route::get('json',function (){
        $response = Illuminate\Support\Facades\Http::get('http://avlaes.disatelgps.com/ws/?api=VehicleHistory&sitekey=avlaes&usr=admin&pwd=aes&veh=AES332&dat=2021-04-25')->json();
        return $response[0]['OdometerSW'];
    });

});

Route::get('/', 'Auth\LoginController@showLoginForm')->name('principal');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware(['workshops'])->group(function () {
    Route::get('/taller', function () {
        return view('contenido.taller');
    })->name('workshops');

    Route::prefix('listado-taller')->group(function () {
        Route::get('/', 'ControllerForWorkshops@getListadoMantenimientos');
        Route::post('/register','ControllerForWorkshops@registerMantenimiento');
    });
});
