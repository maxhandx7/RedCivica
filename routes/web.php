<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\AnaliticaController;
use App\Http\Controllers\BusinessController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RedController;
use App\Http\Controllers\ReferenciaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::permanentRedirect('/', '/login');


Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    // Red de referidos (estructura jerárquica)
    Route::get('/red', [RedController::class, 'index'])->name('red.index');

    Route::resource('business', BusinessController::class)->names('business')->only([
        'index',
        'update'
    ]);

    Route::get('/actividades', [ActividadController::class, 'index'])->name('actividades.index');

    // Referencias
    Route::resource('referencias', ReferenciaController::class)->names('referencias')->except([
        'show',
        'mostrarFormularioRegistro'
    ]);

    Route::get('/referidos/registro', [ReferenciaController::class, 'mostrarFormularioRegistro'])
        ->name('referidos.registro');

    Route::resource('users', UserController::class)->names('users');

    Route::get('/analitica', [AnaliticaController::class, 'index'])->name('analitica.index');
});

Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);

Auth::routes();


