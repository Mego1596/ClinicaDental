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
	Route::get('expediente_create_especial','ExpedienteController@expediente_especial')->name('expedientes.especial');

	//CITAS
	Route::get('citas/create','CitaController@create')->name('citas.create');
	Route::post('citas/','CitaController@store')->name('citas.store');
});
