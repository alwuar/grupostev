<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Panel de prospectos: servicios, prospectos, historial de contacto
 * y rol/acceso de los usuarios del panel.
 */
return new class extends Migration
{
    public function up(): void
    {
        // ===== Usuarios del panel: rol y si pueden entrar =====
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('asesor')->after('password');
            $table->boolean('activo')->default(true)->after('role');
        });

        // ===== Servicios que se ofrecen en el formulario =====
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique();
            $table->unsignedSmallInteger('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        $ahora = now();
        DB::table('services')->insert([
            ['nombre' => 'Traslado de valores', 'orden' => 1, 'activo' => true, 'created_at' => $ahora, 'updated_at' => $ahora],
            ['nombre' => 'Recolección de efectivo', 'orden' => 2, 'activo' => true, 'created_at' => $ahora, 'updated_at' => $ahora],
            ['nombre' => 'Custodia de valores', 'orden' => 3, 'activo' => true, 'created_at' => $ahora, 'updated_at' => $ahora],
        ]);

        // ===== Prospectos que llegan desde la web =====
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('telefono', 30);
            $table->string('email')->nullable();
            $table->string('empresa')->nullable();
            $table->string('ciudad')->nullable();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->string('estado', 20)->default('recibido')->index();
            $table->string('origen', 40)->default('formulario-web');
            $table->timestamp('consentimiento_at')->nullable();
            $table->timestamp('ultimo_contacto_at')->nullable();
            $table->string('ip', 45)->nullable();
            $table->timestamps();

            $table->index('created_at');
        });

        // ===== Historial de contacto / cambios de estado =====
        Schema::create('lead_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('tipo', 20)->default('contacto');   // contacto | interes | sistema
            $table->string('estado_anterior', 20)->nullable();
            $table->string('estado', 20);
            $table->string('asunto');
            $table->string('medio', 20)->nullable();           // whatsapp, llamada, correo
            $table->text('nota')->nullable();
            $table->timestamps();

            $table->index(['lead_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_activities');
        Schema::dropIfExists('leads');
        Schema::dropIfExists('services');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'activo']);
        });
    }
};
