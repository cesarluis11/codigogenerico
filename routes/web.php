<?php

// DB::listen(function($query){
// 	echo "<pre>{$query->sql}</pre>";
// });

Auth::routes();

//Route::view('/home','home');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

// seccion de codigos Genericos Bakan
Route::get('bakanCreate',['as' => 'bakan.create','uses' => 'CodGenericoBakanController@create']);
Route::post('bakane',['as' => 'bakan.store','uses' => 'CodGenericoBakanController@store']);
Route::get('getArticulo',['as' => 'bakan.getArticulo','uses' => 'CodGenericoBakanController@getArticulo']);
Route::get('indexBusquedaBakan',['as' => 'bakan.indexBusqueda','uses' => 'CodGenericoBakanController@indexBusqueda']);
Route::get('revisionBakan',['as' => 'bakan.revision','uses' => 'CodGenericoBakanController@revisionBakan']);
Route::get('updateRevisionBakan',['as' =>'bakan.updateRevision','uses' => 'CodGenericoBakanController@updateRevision']);
Route::get('showDescBakan/{articulo}',['as' => 'bakan.showDescBakan','uses' => 'CodGenericoBakanController@showDescBakan']);
Route::put('updateDescBakan/{articulo}',['as' => 'bakan.updateDescBakan','uses' => 'CodGenericoBakanController@updateDescBakan']);
Route::get('indexAddComGenBakan',['as' => 'bakan.indexAddComGenBakan','uses' => 'CodGenericoBakanController@indexAddComGenBakan']);
Route::get('showAddComGenBakan/{art}',['as' => 'bakan.showAddComGenBakan','uses' => 'CodGenericoBakanController@showAddComGenBakan']);

// seccion de codigos genericos Durex
Route::get('durexCreate',['as' => 'durex.create','uses' => 'CodGenericoDurexController@create']);
Route::post('durexStore',['as' => 'durex.store','uses' => 'CodGenericoDurexController@store']);
Route::get('indexBusquedaDurex',['as' => 'durex.indexBusqueda','uses' => 'CodGenericoDurexController@indexBusqueda']);
Route::get('revisionDurex',['as' => 'durex.revision','uses' => 'CodGenericoDurexController@revisionDurex']);
Route::get('showDescDurex/{articulo}',['as' => 'durex.showDescDurex','uses' => 'CodGenericoDurexController@showDescDurex']);
Route::put('updateDescDurex/{articulo}',['as' => 'durex.updateDescDurex','uses' => 'CodGenericoDurexController@updateDescDurex']);
//seccion de usuarios
Route::group(['middleware' => ['role:super-admin']], function () {

	Route::get('usuarios',['as' => 'usuarios.index','uses' => 'UsuariosController@index']);
	Route::get('nuevoUsuario',['as' => 'usuarios.create','uses' => 'UsuariosController@create']);
	Route::post('crearUsuario',['as' => 'usuarios.store','uses' => 'UsuariosController@store']);
	Route::get('editar/{id}',['as' => 'usuarios.edit','uses' => 'UsuariosController@edit']);
	Route::put('actualizar/{id}',['as' => 'usuarios.update','uses' => 'UsuariosController@update']);
	Route::get('baja/{id}',['as' => 'usuarios.baja','uses' => 'UsuariosController@baja']);

});


