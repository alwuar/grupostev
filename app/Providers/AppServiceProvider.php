<?php

namespace App\Providers;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Compatibilidad con MySQL/MariaDB antiguos: índices de texto de máx. 191 caracteres
        Schema::defaultStringLength(191);

        // El panel usa Bootstrap 5 para la paginación
        Paginator::useBootstrapFive();

        // Fechas en español (oct, lunes, etc.)
        Carbon::setLocale('es');
        CarbonImmutable::setLocale('es');
    }
}
