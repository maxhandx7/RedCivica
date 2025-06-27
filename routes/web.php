<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\AnaliticaController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CampañaController;
use App\Http\Controllers\ConfigController;
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
    Route::get('/actividades/leer', [ActividadController::class, 'marcarComoLeidas'])->name('actividades.leer');

    // Referencias
    Route::resource('referencias', ReferenciaController::class)->names('referencias')->except([
        'show',
        'mostrarFormularioRegistro'
    ]);


    Route::resource('configs', ConfigController::class)->only(['edit', 'update']);
    Route::post('/profile/image', [ConfigController::class, 'updateProfileImage'])->name('update_profile_image');
    Route::post('cambiarContrasena', [ConfigController::class, 'updatePassword'])->name('update_password');
    Route::get('/cambiar-contrasena', [ConfigController::class, 'showChangePasswordForm'])->name('password.change');

    Route::resource('users', UserController::class)->names('users');

    Route::resource('campañas', CampañaController::class)->names('campañas');

    Route::get('/analitica', [AnaliticaController::class, 'index'])->name('analitica.index');
});
Route::get('/referidos/registro', [ReferenciaController::class, 'mostrarFormularioRegistro'])
    ->name('referidos.registro');
Route::post('/referidos/create', [UserController::class, 'form'])->name('users.form');
Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);

Auth::routes();


