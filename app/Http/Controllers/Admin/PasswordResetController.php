<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

/** "Olvidé mi contraseña" del panel: pedir enlace por correo y crear una nueva */
class PasswordResetController extends Controller
{
    /** Mismo mensaje exista o no el correo, para no revelar quién tiene cuenta */
    private const MENSAJE_ENVIADO = 'Si el correo pertenece a un usuario activo del panel, te enviamos un enlace para crear una nueva contraseña. Revisa tu bandeja de entrada y la carpeta de spam.';

    public function request(): View
    {
        return view('admin.auth.forgot-password');
    }

    public function email(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']], [], ['email' => 'correo']);

        $email = Str::lower($request->string('email')->toString());

        // Solo se envía a usuarios activos; a los demás no, pero la respuesta es la misma
        if (User::where('email', $email)->where('activo', true)->exists()) {
            Password::sendResetLink(['email' => $email]);
        }

        return back()->with('status', self::MENSAJE_ENVIADO);
    }

    public function reset(Request $request, string $token): View
    {
        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => $request->string('email')->toString(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
        ], [
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ], [
            'email' => 'correo',
            'password' => 'contraseña',
        ]);

        $estado = Password::reset(
            [
                'email' => Str::lower($request->string('email')->toString()),
                'password' => $request->input('password'),
                'password_confirmation' => $request->input('password_confirmation'),
                'token' => $request->input('token'),
            ],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password,
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($estado !== Password::PASSWORD_RESET) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'El enlace ya venció o no es válido. Pide uno nuevo desde "¿Olvidaste tu contraseña?".']);
        }

        return redirect()->route('admin.login')
            ->with('status', 'Listo, tu contraseña se actualizó. Ya puedes iniciar sesión.');
    }
}
