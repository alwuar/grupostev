<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Recuperar contraseña | Panel Grupo STEV</title>
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
        <h1>¿Olvidaste tu contraseña?</h1>
        <p class="sub mb-4">Escribe el correo con el que entras al panel y te enviaremos un enlace para crear una nueva.</p>

        @if (session('status'))
            <div class="alert alert-success small" role="status">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.password.email') }}" novalidate>
            @csrf

            <div class="mb-4">
                <label for="email" class="form-label">Correo</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="username" required autofocus
                       class="form-control @error('email') is-invalid @enderror">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-mx w-100 py-2">Enviar enlace</button>
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
