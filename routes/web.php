<?php

use App\Exports\ClientesExport;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\AnaliticaController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CampañaController;
use App\Http\Controllers\ConfigController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NeedController;
use App\Http\Controllers\RedController;
use App\Http\Controllers\ReferenciaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Exports\UsuariosExport;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropuestaController;
use App\Http\Controllers\TarjetonController;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsuariosImport;
use Illuminate\Http\Request;

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
    Route::get('/users-by-department', [DashboardController::class, 'usersByDepartment']);

    // Red de referidos (estructura jerárquica)
    Route::get('/red', [RedController::class, 'index'])->name('red.index');

    Route::get('/candidato-dash', [App\Http\Controllers\HomeController::class, 'candidatoDash'])->name('candidato.dashboard');

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
    Route::get('/analitica/{id}/usuarios-por-referencia', [AnaliticaController::class, 'usuariosPorReferencia'])->name('analitica.usuarios_por_referencia');

    Route::get('/needs', [NeedController::class, 'index'])->name('needs.index');
    Route::post('/needs', [NeedController::class, 'store'])->name('needs.store');
    Route::put('/needs/{id}', [NeedController::class, 'update'])->name('needs.update');
    Route::delete('/needs/{id}', [NeedController::class, 'destroy'])->name('needs.destroy');
    Route::patch('/needs/{id}/complete', [NeedController::class, 'toggleComplete'])->name('needs.toggle');


    Route::get('/exportar-usuarios', function () {
        return Excel::download(new UsuariosExport, 'usuarios.xlsx');
    });

    Route::get('/exportar-clientes', function () {
        return Excel::download(new ClientesExport, 'clientes.xlsx');
    });
    Route::post('/importar-usuarios', function (Request $request) {
        Excel::import(new UsuariosImport, $request->file('archivo_excel'));
        return redirect()->back()->with('success', 'Los usuarios han sido importados correctamente.');
    });

    Route::resource('questions', App\Http\Controllers\QuestionController::class)->names('questions');
    Route::get('/questions/departments', [App\Http\Controllers\QuestionController::class, 'getDepartments'])->name('questions.departments');
    Route::get('/questions/cities/{department}', [App\Http\Controllers\QuestionController::class, 'getCities'])->name('questions.cities');


    // Candidatos
    Route::resource('candidatos', CandidatoController::class)->names('candidatos');

    Route::post('/candidatos/{candidato}/toggle-activo', [CandidatoController::class, 'toggleActivo'])->name('candidatos.toggle-activo');
    Route::post('/candidatos/reordenar', [CandidatoController::class, 'reordenar'])->name('candidatos.reordenar');
    Route::get('/candidatos/{candidato}/metricas', [CandidatoController::class, 'metricas'])->name('candidatos.metricas');
    Route::post('/candidatos/{candidato}/metricas', [CandidatoController::class, 'guardarMetrica'])->name('candidatos.metricas.store');
    
    // Propuestas
    Route::prefix('candidatos/{candidato}')->group(function () {
        Route::get('/propuestas', [PropuestaController::class, 'index'])->name('candidatos.propuestas.index');
        Route::get('/propuestas/create', [PropuestaController::class, 'create'])->name('candidatos.propuestas.create');
        Route::post('/propuestas', [PropuestaController::class, 'store'])->name('candidatos.propuestas.store');
        Route::get('/propuestas/{propuesta}/edit', [PropuestaController::class, 'edit'])->name('candidatos.propuestas.edit');
        Route::put('/propuestas/{propuesta}', [PropuestaController::class, 'update'])->name('candidatos.propuestas.update');
        Route::delete('/propuestas/{propuesta}', [PropuestaController::class, 'destroy'])->name('candidatos.propuestas.destroy');
        Route::post('/propuestas/{propuesta}/toggle-destacada', [PropuestaController::class, 'toggleDestacada'])->name('candidatos.propuestas.toggle-destacada');
        Route::post('/propuestas/reordenar', [PropuestaController::class, 'reordenar'])->name('candidatos.propuestas.reordenar');
    });
    
    // Tarjetones
    Route::resource('tarjetones', TarjetonController::class)->names('tarjetones');
    Route::post('/tarjetones/{tarjeton}/toggle-activo', [TarjetonController::class, 'toggleActivo'])->name('tarjetones.toggle-activo');
    Route::get('/tarjetones/{tarjeton}/preview', [TarjetonController::class, 'preview'])->name('tarjetones.preview');
    Route::post('/tarjetones/{tarjeton}/duplicate', [TarjetonController::class, 'duplicate'])->name('tarjetones.duplicate');
    Route::get('/tarjetones/{tarjeton}/export', [TarjetonController::class, 'exportPdf'])->name('tarjetones.export-pdf');
    Route::get('/tarjetones/{tarjeton}/export-image', [TarjetonController::class, 'exportImage'])->name('tarjetones.export-image');
    
    // Documentos
    Route::resource('documentos', DocumentoController::class);
    
    // Configuración
   
        Route::get('/general', function () { return view('admin.configuracion.general'); })->name('configuracion.general');
        Route::get('/categorias', function () { return view('admin.configuracion.categorias'); })->name('configuracion.categorias');
        Route::get('/estadisticas', function () { return view('admin.configuracion.estadisticas'); })->name('configuracion.estadisticas');
   

});

Route::post('/questions/by-location', [App\Http\Controllers\QuestionController::class, 'byLocation'])
    ->name('questions.byLocation');

Route::post('/questions/guardar', [App\Http\Controllers\QuestionController::class, 'guardar'])
    ->name('guardar.question');

Route::get('/referidos/registro', [ReferenciaController::class, 'mostrarFormularioRegistro'])
    ->name('referidos.registro');
Route::post('/referidos/create', [UserController::class, 'form'])->name('users.form');
Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);




Route::get('/generate-sitemap', function () {
    Sitemap::create()
        ->add(Url::create('/'))
        ->writeToFile(public_path('sitemap.xml'));

    return 'Sitemap generado ✅';
});

Route::post('check-cedula', [UserController::class, 'checkCedula'])->name('users.check_cedula');

Auth::routes();

Route::get('/{alias}', [HomeController::class, 'candidatoPage'])
    ->name('candidato.alias');


