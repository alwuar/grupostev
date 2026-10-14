<?php

namespace App\Notifications;

use App\Models\Lead;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/** Aviso por correo de cada prospecto que llena el formulario de la web */
class NuevoProspecto extends Notification
{
    public function __construct(public Lead $lead) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $lead = $this->lead->loadMissing(['service']);

        $mensaje = (new MailMessage)
            ->subject("Nuevo prospecto {$lead->folio()} · {$lead->nombre}")
            ->view(['emails.nuevo-prospecto', 'emails.nuevo-prospecto-texto'], [
                'lead' => $lead,
                'datos' => $this->datos($lead),
                'fecha' => $lead->created_at?->timezone(config('app.timezone'))->format('d/m/Y H:i'),
                'urlPanel' => route('admin.leads.show', $lead),
                'urlWhatsApp' => 'https://wa.me/'.$lead->telefonoInternacional(),
                'urlVandu' => $this->urlVandu(),
            ]);

        // "Responder" en el correo le escribe directo al prospecto
        if ($lead->email) {
            $mensaje->replyTo($lead->email, $lead->nombre);
        }

        return $mensaje;
    }

    /** Datos del prospecto en el orden en que se muestran (los vacíos se omiten) */
    private function datos(Lead $lead): array
    {
        return array_filter([
            'Teléfono' => $lead->telefono,
            'Correo' => $lead->email,
            'Empresa' => $lead->empresa,
            'Ciudad' => $lead->ciudad,
            'Servicio de interés' => $lead->interesLabel() ?? 'Sin definir',
            'Llegó desde' => $lead->origen ? $lead->origenLabel() : null,
        ], fn ($valor) => filled($valor));
    }

    /** "Platicar con un asesor": WhatsApp de Vandu si está configurado, si no su sitio */
    private function urlVandu(): string
    {
        $numero = preg_replace('/\D+/', '', (string) config('services.vandu.whatsapp'));

        if (! $numero) {
            return 'https://agenciavandu.com';
        }

        return 'https://wa.me/'.$numero.'?text='.rawurlencode('Hola Vandu, necesito una funcionalidad nueva para el panel de Grupo STEV.');
    }
}
