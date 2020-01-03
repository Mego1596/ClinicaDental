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
Route::get('/perfil', 'HomeController@perfil')->name('perfil');
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

	//PLAN DE TRATAMIENTO DE UNA PERSONA
	Route::get('plan_tratamiento/{persona}', 'ExpedienteController@planes')->name('expedientes.planes');
	Route::get('plan_tratamiento_actual/{cita}', 'ExpedienteController@plan')->name('expedientes.plan');


	//ODONTOGRAMAS
	Route::get('odontograma/inicial/{expediente}','OdontogramaController@inicial')->name('odontogramas.inicial');
	Route::get('odontograma/tratamiento/{cita}','OdontogramaController@tratamiento')->name('odontogramas.tratamiento');
	Route::post('odontogramas','OdontogramaController@store')->name('odontogramas.store');
	Route::delete('odontogramas/{odontograma}','OdontogramaController@destroy')->name('odontogramas.destroy');
});
