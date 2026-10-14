<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Iniciar sesión | Panel Grupo STEV</title>
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
        <h1>Panel de administración</h1>
        <p class="sub mb-4">Acceso exclusivo para el equipo de Grupo STEV.</p>

        @if (session('status'))
            <div class="alert alert-success small" role="status">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.store') }}" novalidate>
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Correo</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="username" required autofocus
                       class="form-control @error('email') is-invalid @enderror">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" autocomplete="current-password" required
                       class="form-control @error('password') is-invalid @enderror">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                <div class="form-check m-0">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
                    <label class="form-check-label" for="remember">Mantener sesión iniciada</label>
                </div>
                <a href="{{ route('admin.password.request') }}" class="small">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit" class="btn btn-mx w-100 py-2">Entrar</button>
        </form>
    </main>

    <p class="login-credito">
        Desarrollado por <a href="https://agenciavandu.com" target="_blank" rel="noopener">agenciavandu.com</a>
    </p>
</body>
</html>
