<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;

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

// Rotas públicas
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

// Rotas de autenticação
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Rotas protegidas
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // CRM - Clientes (apenas admin e technician)
    Route::middleware('role:admin,technician')->group(function () {
        Route::resource('clientes', \App\Http\Controllers\ClienteController::class);
    });

    // Ordens de Serviço
    Route::middleware('role:admin,technician')->group(function () {
        Route::resource('servicos', \App\Http\Controllers\ServicoController::class);
        Route::get('servicos/{servico}/executar', [\App\Http\Controllers\ServicoController::class, 'executar'])->name('servicos.executar');
        Route::post('servicos/{servico}/executar', [\App\Http\Controllers\ServicoController::class, 'salvarExecucao'])->name('servicos.salvar-execucao');
        
        // Laudos
        Route::post('servicos/{servico}/gerar-laudo', [\App\Http\Controllers\LaudoController::class, 'gerar'])->name('laudos.gerar');
        Route::get('laudos/{laudo}', [\App\Http\Controllers\LaudoController::class, 'show'])->name('laudos.show');
        Route::get('laudos/{laudo}/download', [\App\Http\Controllers\LaudoController::class, 'download'])->name('laudos.download');
        Route::post('laudos/{laudo}/enviar-assinatura', [\App\Http\Controllers\LaudoController::class, 'enviarAssinatura'])->name('laudos.enviar-assinatura');
        
        // Templates de Laudos (apenas admin)
        Route::middleware('role:admin')->group(function () {
            Route::resource('laudo-templates', \App\Http\Controllers\LaudoTemplateController::class);
            
            // Relatórios
            Route::get('relatorios', [\App\Http\Controllers\RelatorioController::class, 'index'])->name('relatorios.index');
            Route::get('relatorios/clientes', [\App\Http\Controllers\RelatorioController::class, 'clientes'])->name('relatorios.clientes');
            Route::get('relatorios/servicos', [\App\Http\Controllers\RelatorioController::class, 'servicos'])->name('relatorios.servicos');
            Route::get('relatorios/laudos', [\App\Http\Controllers\RelatorioController::class, 'laudos'])->name('relatorios.laudos');
        });
    });
});

// Rotas públicas de assinatura (sem autenticação)
Route::get('assinar/{uuid}', [\App\Http\Controllers\AssinaturaController::class, 'show'])->name('assinatura.show');
Route::post('assinar/{uuid}/canvas', [\App\Http\Controllers\AssinaturaController::class, 'assinarCanvas'])->name('assinatura.canvas');
Route::post('assinar/{uuid}/biometria', [\App\Http\Controllers\AssinaturaController::class, 'assinarBiometria'])->name('assinatura.biometria');
