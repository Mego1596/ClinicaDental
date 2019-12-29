<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function(){
	
	//USUARIOS
	Route::resource('users','UserController');
	
	//ROLES
	Route::resource('roles','RolController');
	
	//PROCEDIMIENTOS
	Route::resource('procedimientos','ProcedimientoController');
	
	//EXPEDIENTE
	Route::resource('expedientes','ExpedienteController');
	Route::get('expediente_create_especial/{persona}','ExpedienteController@expediente_especial')->name('expedientes.especial');

	//CITAS
	Route::resource('citas','CitaController');
	Route::put('citas/reprogramar/{cita}','CitaController@reprogramar')->name('citas.reprogramar');
	Route::post('citas/seguimiento/{cita}','CitaController@seguimiento')->name('citas.seguimiento');

	//PERSONAS
	Route::resource('personas','PersonaController');

	//PAGOS
	Route::resource('citas.pagos','PagoController');

	//RECETAS
	Route::resource('citas.recetas','RecetaController');

	//DETALLE_RECETAS
	Route::resource('recetas.detalles','DetalleRecetaController');

});
