<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Nueva contraseña | Panel Grupo STEV</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <meta name="theme-color" content="#0d0e0e">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/scss/admin.scss'])
</head>
<body class="admin-login">
    <main class="login-card">
        <img src="{{ asset('img/logo-orange.svg') }}" alt="Grupo STEV Seguridad Privada" class="logo" width="140">
        <h1>Crea una nueva contraseña</h1>
        <p class="sub mb-4">Usa al menos 8 caracteres.</p>

        <form method="POST" action="{{ route('admin.password.update') }}" novalidate>
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="email" class="form-label">Correo</label>
                <input type="email" name="email" id="email" value="{{ old('email', $email) }}" autocomplete="username" required
                       class="form-control @error('email') is-invalid @enderror">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Nueva contraseña</label>
                <input type="password" name="password" id="password" autocomplete="new-password" required minlength="8" autofocus
                       class="form-control @error('password') is-invalid @enderror">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Repite la contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" required minlength="8"
                       class="form-control">
            </div>

            <button type="submit" class="btn btn-mx w-100 py-2">Guardar contraseña</button>
        </form>

        <p class="text-center mt-3 mb-0 small">
            <a href="{{ route('admin.login') }}">← Volver a iniciar sesión</a>
        </p>
    </main>

    <p class="login-credito">
        Desarrollado por <a href="https://agenciavandu.com" target="_blank" rel="noopener">agenciavandu.com</a>
    </p>
</body>
</html>
