<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\LeadActivityController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Admin\PasswordResetController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::view('/aviso-de-privacidad', 'aviso-privacidad')->name('aviso-privacidad');

// Formulario del sitio → guarda prospecto → abre WhatsApp
Route::post('/contacto', [LeadController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('leads.store');

// ===== Panel administrativo =====
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'create'])->name('login');
        Route::post('login', [AuthController::class, 'store'])->name('login.store');

        // Olvidé mi contraseña
        Route::get('olvide-mi-contrasena', [PasswordResetController::class, 'request'])->name('password.request');
        Route::post('olvide-mi-contrasena', [PasswordResetController::class, 'email'])
            ->middleware('throttle:5,1')->name('password.email');
        Route::get('restablecer-contrasena/{token}', [PasswordResetController::class, 'reset'])->name('password.reset');
        Route::post('restablecer-contrasena', [PasswordResetController::class, 'update'])
            ->middleware('throttle:10,1')->name('password.update');
    });

    // Todos los usuarios del panel (administradores y asesores)
    Route::middleware(['auth', 'panel'])->group(function () {
        Route::post('logout', [AuthController::class, 'destroy'])->name('logout');

        Route::redirect('/', '/admin/prospectos')->name('home');

        Route::get('prospectos', [AdminLeadController::class, 'index'])->name('leads.index');
        Route::get('prospectos/exportar', [AdminLeadController::class, 'export'])->name('leads.export');
        Route::get('prospectos/{lead}', [AdminLeadController::class, 'show'])->name('leads.show');
        Route::post('prospectos/{lead}/actividad', [LeadActivityController::class, 'store'])->name('leads.activities.store');
        Route::put('prospectos/{lead}/interes', [AdminLeadController::class, 'updateInteres'])->name('leads.interes');

        Route::get('estadisticas', [StatsController::class, 'index'])->name('stats.index');

        // Solo administradores
        Route::middleware('admin')->group(function () {
            Route::get('usuarios', [UserController::class, 'index'])->name('users.index');
            Route::get('usuarios/nuevo', [UserController::class, 'create'])->name('users.create');
            Route::post('usuarios', [UserController::class, 'store'])->name('users.store');
            Route::get('usuarios/{user}/editar', [UserController::class, 'edit'])->name('users.edit');
            Route::put('usuarios/{user}', [UserController::class, 'update'])->name('users.update');

            Route::get('servicios', [ServiceController::class, 'index'])->name('services.index');
            Route::put('servicios', [ServiceController::class, 'update'])->name('services.update');
            Route::post('servicios', [ServiceController::class, 'store'])->name('services.store');
        });
    });
});
