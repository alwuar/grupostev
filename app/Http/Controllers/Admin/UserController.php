<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/** Alta y edición de usuarios del panel (solo administradores) */
class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::orderByDesc('activo')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.form', [
            'user' => new User(['role' => UserRole::Asesor, 'activo' => true]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $this->validar($request);

        User::create($datos);

        return redirect()->route('admin.users.index')->with('status', 'Usuario creado.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.form', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $datos = $this->validar($request, $user);

        // No te puedes quitar el acceso a ti mismo ni dejar el panel sin administradores
        $dejaDeSerAdmin = $user->isAdmin() && ($datos['role'] !== UserRole::Admin->value || ! $datos['activo']);
        if ($dejaDeSerAdmin) {
            if ($user->is($request->user())) {
                throw ValidationException::withMessages(['role' => 'No puedes quitarte tu propio acceso de administrador.']);
            }
            if (User::where('role', UserRole::Admin)->where('activo', true)->count() <= 1) {
                throw ValidationException::withMessages(['role' => 'Debe quedar al menos un administrador activo.']);
            }
        }

        if (blank($datos['password'] ?? null)) {
            unset($datos['password']);
        }

        $user->update($datos);

        return redirect()->route('admin.users.index')->with('status', 'Usuario actualizado.');
    }

    private function validar(Request $request, ?User $user = null): array
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user?->id)],
            'role' => ['required', Rule::enum(UserRole::class)],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8', 'max:100'],
            'activo' => ['nullable', 'boolean'],
        ], [], [
            'name' => 'nombre',
            'email' => 'correo',
            'role' => 'rol',
            'password' => 'contraseña',
        ]);

        $datos['email'] = strtolower($datos['email']);
        $datos['activo'] = $request->boolean('activo');
        return $datos;
    }
}
