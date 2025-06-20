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
   // return view('home');
    return view('auth/login');

});



Route::get('precalificacion', [App\Http\Controllers\Controller::class, 'vistaproceso']);

Route::post('home/precalificacion', [App\Http\Controllers\ClientesPreController::class, 'store']);
 
// Route::get('agradecimiento', function () {
//     return view('calificacion');
// });


//Route::get('login_preaproval', [App\Http\Controllers\HomeController::class, 'Vista_login']);

Route::middleware(['auth'])->group(function () {

    // Route::get('/home', function () {
    //     return view('manager');
    // });
    
    Route::get('/home', [App\Http\Controllers\Controller::class, 'vistaDataFormularios']);


    Route::post('formulariodatos', [App\Http\Controllers\ClientesPreController::class, 'datosform']);

    Route::post('seminarios', [App\Http\Controllers\ClientesPreController::class, 'datosform_seminarios']);

    Route::post('seminarios-preregistro', [App\Http\Controllers\ClientesPreController::class, 'form_semi_preregistro']);

    Route::post('registros-pdf', [App\Http\Controllers\ClientesPreController::class, 'form_registro_pdf']);


    Route::post('registro/listado/{id}', [App\Http\Controllers\SeguimientoController::class, 'show']);

    Route::get('lista_cliente', [App\Http\Controllers\ClientesPreController::class, 'show']);

    Route::get('vis_usuarios', [App\Http\Controllers\HomeController::class, 'Vista_registro']);

    Route::get('usuarios', [App\Http\Controllers\Controller::class, 'vista_user'])->name('usuarios');

    Route::post('registro/guardar', [App\Http\Controllers\UserController::class, 'create_user']);

    Route::get('usuarios/mostrar', [App\Http\Controllers\UserController::class, 'show']);

    Route::post('usuario/editar/{id}', [App\Http\Controllers\UserController::class, 'edit']);

    Route::post('registro/actualizar', [App\Http\Controllers\UserController::class, 'update']);

    Route::post('registro/eliminar/{id}', [App\Http\Controllers\UserController::class, 'destroy']);

    Route::post('registro/guardar_seguimiento', [App\Http\Controllers\SeguimientoController::class, 'create']);


    Route::post('registro/estado_resgitro/{id}/{estado}', [App\Http\Controllers\EstadoregistroController::class, 'estadoRegistroForm']);

    Route::post('registro/bitacora/{id}', [App\Http\Controllers\BitacoraController::class, 'show']);

    Route::post('campana/mensajes', [App\Http\Controllers\ClientesPreController::class, 'Envio_campana']);

    Route::get('seminario/exportar/{estado}', [App\Http\Controllers\ClientesPreController::class, 'exportseminario']);


    Route::prefix('usuarios/permisos')->group(function () {
        // Route::get('/', [App\Http\Controllers\UserPermissionController::class, 'index'])->name('index');
        // Route::get('/crear', [App\Http\Controllers\UserPermissionController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\UserPermissionController::class, 'store'])->name('asiganar.permiso.usuario');
        Route::post('/{id}', [App\Http\Controllers\UserPermissionController::class, 'destroy'])->name('show');
        Route::post('/{id}/editar', [App\Http\Controllers\UserPermissionController::class, 'edit'])->name('edit');
        // Route::put('/{id}', [App\Http\Controllers\UserPermissionController::class, 'update'])->name('update');
        // Route::delete('/{id}', [App\Http\Controllers\UserPermissionController::class, 'destroy'])->name('destroy');
    });



});
