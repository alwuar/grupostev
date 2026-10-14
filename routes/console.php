<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
 * Crea (o actualiza) un usuario del panel.
 * Uso: php artisan admin:crear correo@stevseguridadprivada.com --nombre="Alvar"
 *      php artisan admin:crear asesor@stevseguridadprivada.com --nombre="Ana" --rol=asesor
 */
Artisan::command('admin:crear {email} {--nombre=Administrador} {--rol=admin}', function (string $email) {
    $validator = Validator::make(['email' => $email], ['email' => 'required|email']);
    if ($validator->fails()) {
        $this->error('El correo no es válido.');

        return 1;
    }

    $rol = UserRole::tryFrom((string) $this->option('rol'));
    if (! $rol) {
        $this->error('El rol debe ser "admin" o "asesor".');

        return 1;
    }

    $password = $this->secret('Contraseña (mínimo 8 caracteres)');
    if (! is_string($password) || strlen($password) < 8) {
        $this->error('La contraseña debe tener al menos 8 caracteres.');

        return 1;
    }

    $user = User::updateOrCreate(
        ['email' => strtolower($email)],
        ['name' => $this->option('nombre'), 'password' => $password, 'role' => $rol, 'activo' => true],
    );

    $this->info("Usuario listo: {$user->email} ({$rol->label()})");

    return 0;
})->purpose('Crear o actualizar un usuario del panel');
