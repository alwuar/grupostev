<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Deja pasar al panel solo a usuarios activos.
 * Si alguien pierde el acceso mientras tiene sesión, se cierra.
 */
class EnsurePanelAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->puedeEntrar()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Tu cuenta no tiene acceso al panel.']);
        }

        return $next($request);
    }
}
