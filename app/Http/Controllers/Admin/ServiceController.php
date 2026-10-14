<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/** Servicios que aparecen como opción en el formulario del sitio (solo administradores) */
class ServiceController extends Controller
{
    public function index(): View
    {
        return view('admin.services.index', [
            'servicios' => Service::withCount('leads')->orderByDesc('activo')->orderBy('orden')->orderBy('id')->get(),
        ]);
    }

    /** Guarda nombre y visibilidad de todos los servicios de una vez */
    public function update(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'servicios' => ['array'],
            'servicios.*.nombre' => ['required', 'string', 'max:100'],
            'servicios.*.activo' => ['nullable', 'boolean'],
        ], [
            'servicios.*.nombre.required' => 'Cada servicio necesita nombre.',
        ]);

        DB::transaction(function () use ($datos) {
            foreach ($datos['servicios'] ?? [] as $id => $fila) {
                Service::whereKey($id)->first()?->update([
                    'nombre' => trim($fila['nombre']),
                    'activo' => (bool) ($fila['activo'] ?? false),
                ]);
            }
        });

        return redirect()->route('admin.services.index')->with('status', 'Servicios guardados.');
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100', 'unique:services,nombre'],
        ], [
            'nombre.unique' => 'Ya existe un servicio con ese nombre.',
        ], ['nombre' => 'nombre del servicio']);

        Service::create([
            'nombre' => trim($datos['nombre']),
            'orden' => (int) Service::max('orden') + 1,
            'activo' => true,
        ]);

        return redirect()->route('admin.services.index')->with('status', 'Servicio agregado.');
    }
}
