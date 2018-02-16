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
})->name('welcome');

Auth::routes();

Route::get('/idioma/{id}', function($id) {
    session()->put('idioma', $id);
    return back();
})->name('idioma');


Route::group(['middleware' => 'auth'], function() {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/cambiar-estado/{id?}/{estado?}', 'HomeController@cambiarEstado')->name('modificar.estado');
    Route::get('/eliminar/{id?}', 'HomeController@eliminar')->name('eliminar.tarea');
    Route::get('/config', 'HomeController@showConfig')->name('config');

    Route::post('/crear-tarea', 'HomeController@crearTarea')->name('crear.tarea');
    Route::post('/config/pass', 'HomeController@cambiarPass')->name('cambiar.pass');

});

Route::group(['prefix' => 'auth'], function () {
    Route::get('/{provider}', 'Auth\LoginController@redirectToProvider');
    Route::get('/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
});
