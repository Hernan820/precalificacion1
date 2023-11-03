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

Auth::routes();

Route::get('/', function () {
    return view('home');
});



Route::get('precalificacion', [App\Http\Controllers\Controller::class, 'vistaproceso']);

Route::post('home/precalificacion', [App\Http\Controllers\ClientesPreController::class, 'store']);
 
Route::get('agradecimiento', function () {
    return view('calificacion');
});

//Route::get('login_preaproval', [App\Http\Controllers\HomeController::class, 'Vista_login']);

Route::middleware(['auth'])->group(function () {

    Route::get('/home', function () {
        return view('manager');
    });
    

    Route::get('lista_cliente', [App\Http\Controllers\ClientesPreController::class, 'show']);

    Route::get('vis_usuarios', [App\Http\Controllers\HomeController::class, 'Vista_registro']);

    Route::get('usuarios', [App\Http\Controllers\Controller::class, 'vista_user'])->name('usuarios');

    Route::post('registro/guardar', [App\Http\Controllers\UserController::class, 'create_user']);

    Route::get('usuarios/mostrar', [App\Http\Controllers\UserController::class, 'show']);

    Route::post('usuario/editar/{id}', [App\Http\Controllers\UserController::class, 'edit']);

    Route::post('registro/actualizar', [App\Http\Controllers\UserController::class, 'update']);

    Route::post('registro/eliminar/{id}', [App\Http\Controllers\UserController::class, 'destroy']);

    Route::post('registro/guardar_seguimiento', [App\Http\Controllers\SeguimientoController::class, 'create']);

});
