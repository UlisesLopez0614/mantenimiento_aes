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

    //Talleres
    Route::prefix('talleres')->group(function () {
        Route::get('/', 'TallerController@index');
        Route::get('/selectTaller', 'TallerController@selectTaller');
        Route::post('/registrar', 'TallerController@store');
        Route::put('/actualizar', 'TallerController@update');
        Route::put('/desactivar', 'TallerController@desactivar');
        Route::put('/activar', 'TallerController@activar');
    });


    //Tipos de Mantenimiento
    Route::prefix('tipomantos')->group(function () {
        Route::get('/', 'TipomantoController@index');
        Route::get('/selectTipomanto', 'TipomantoController@selectTipomanto');
        Route::get('/info', 'TipomantoController@info');
        Route::post('/registrar', 'TipomantoController@store');
        Route::put('/actualizar', 'TipomantoController@update');
        Route::put('/desactivar', 'TipomantoController@desactivar');
        Route::put('/activar', 'TipomantoController@activar');
    });

    //Llantas
    Route::prefix('usuarios-taller')->group(function () {
        Route::get('/', 'ControllerForWorkshops@getWorkShopsUsers');
        Route::post('/registrar', 'ControllerForWorkshops@registerWorkShopsUser');
        Route::post('/deactivate', 'ControllerForWorkshops@deactivateWorkShopsUsers');
    });

    Route::get('/principales', 'PrincipalController@index');
//----------------------------Rutas De Los Modulos de Mantenimientos
    Route::get('/baterias', 'VehicleDetailsController@getBatteryDetails');
    Route::post('/baterias/registrar', 'VehicleDetailsController@registerBatteryRecord');
    Route::get('/battery_records', 'VehicleDetailsController@getBatteryHistory');

    //Llantas
    Route::prefix('tires')->group(function () {
        Route::get('/', 'VehicleDetailsController@getTireDetails');
        Route::post('/registrar', 'VehicleDetailsController@registerTireRecord');
    });

    Route::get('/tire_records', 'VehicleDetailsController@getTireHistory');

    //Aceites
    Route::prefix('oil')->group(function () {
        Route::get('/', 'VehicleDetailsController@getOilDetails');
        Route::post('/register','VehicleDetailsController@registerOilRecord');
        Route::post('/update','VehicleDetailsController@updateOilRecord');
        Route::get('/records', 'VehicleDetailsController@getOilHistory');
    });
//
    //Mantenimientos
    Route::prefix('mantenimientos')->group(function () {
        Route::get('/', 'MantenimientoController@index');
        Route::post('/registrar', 'MantenimientoController@store');
    });

    Route::get('/vehiculos/historial', 'MantenimientoController@refrescarOdometro');

    Route::get('/reportes/consolidado', 'ReporteriaController@consolidado');
    Route::get('/reportes/consolidadoDescargar', 'ReporteriaController@consolidadoDescargar');

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
