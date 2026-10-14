<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

/** Correo en español con el enlace para crear una nueva contraseña del panel */
class RestablecerContrasena extends ResetPassword
{
    public function toMail($notifiable): MailMessage
    {
        $url = route('admin.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);

        $minutos = config('auth.passwords.'.config('auth.defaults.passwords').'.expire');

        return (new MailMessage)
            ->subject('Restablece tu contraseña del panel de Grupo STEV')
            ->greeting('Hola, '.$notifiable->name)
            ->line('Recibimos una solicitud para restablecer la contraseña de tu cuenta del panel de Grupo STEV.')
            ->action('Crear nueva contraseña', $url)
            ->line("Este enlace vence en {$minutos} minutos.")
            ->line('Si tú no lo pediste, ignora este correo: tu contraseña actual sigue funcionando.')
            ->salutation('Equipo Grupo STEV');
    }
}
