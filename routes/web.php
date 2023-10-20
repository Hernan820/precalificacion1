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

Route::get('login_preaproval', [App\Http\Controllers\HomeController::class, 'Vista_login']);

Route::get('register_preaproval', [App\Http\Controllers\HomeController::class, 'Vista_registro']);


//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
