@php
    use App\Enums\UserRole;
    $editando = $user->exists;
    $rolActual = old('role', $user->role?->value ?? 'asesor');
@endphp

<x-admin.layout :title="$editando ? 'Editar usuario' : 'Nuevo usuario'">

    <a href="{{ route('admin.users.index') }}" class="d-inline-flex align-items-center gap-1 text-decoration-none small mb-2">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
        Usuarios
    </a>

    <div class="page-head">
        <h1>{{ $editando ? $user->name : 'Nuevo usuario' }}</h1>
    </div>

    <form method="POST" action="{{ $editando ? route('admin.users.update', $user) : route('admin.users.store') }}"
          class="mx-card form-angosto" novalidate>
        @csrf
        @if ($editando) @method('PUT') @endif

        <div class="row g-3">
            <div class="col-12 col-md-6">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required maxlength="100"
                       class="form-control @error('name') is-invalid @enderror">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12 col-md-6">
                <label for="email" class="form-label">Correo (para iniciar sesión)</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required autocomplete="off"
                       class="form-control @error('email') is-invalid @enderror">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <fieldset class="col-12">
                <legend class="form-label fs-6 mb-2">Rol</legend>
                <div class="opciones-rol">
                    @foreach (UserRole::cases() as $rol)
                        <input type="radio" name="role" id="rol-{{ $rol->value }}" value="{{ $rol->value }}" @checked($rolActual === $rol->value)>
                        <label for="rol-{{ $rol->value }}">
                            <strong>{{ $rol->label() }}</strong>
                            <span>{{ $rol->descripcion() }}</span>
                        </label>
                    @endforeach
                </div>
                @error('role')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </fieldset>

            <div class="col-12 col-md-6">
                <label for="password" class="form-label">{{ $editando ? 'Nueva contraseña (opcional)' : 'Contraseña' }}</label>
                <input type="password" name="password" id="password" autocomplete="new-password" minlength="8"
                       placeholder="{{ $editando ? 'Déjala vacía para no cambiarla' : 'Mínimo 8 caracteres' }}"
                       class="form-control @error('password') is-invalid @enderror">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-12">
                <div class="form-check form-switch">
                    <input type="hidden" name="activo" value="0">
                    <input class="form-check-input" type="checkbox" role="switch" name="activo" id="activo" value="1"
                           @checked(old('activo', $user->activo ?? true))>
                    <label class="form-check-label" for="activo">Puede iniciar sesión</label>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
            <button type="submit" class="btn btn-mx">{{ $editando ? 'Guardar cambios' : 'Crear usuario' }}</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-mx-outline">Cancelar</a>
        </div>
    </form>

</x-admin.layout>
