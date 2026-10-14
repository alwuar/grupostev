<?php

namespace App\Support;

use App\Models\Lead;

/**
 * Arma el mensaje preformateado que el prospecto envía por WhatsApp
 * después de llenar el formulario.
 */
class WhatsAppMessage
{
    public static function forLead(Lead $lead): string
    {
        $lineas = [
            '¡Hola Grupo STEV! 👋 Quiero información sobre sus servicios de seguridad.',
            '',
            '*Folio:* '.$lead->folio(),
            '*Nombre:* '.$lead->nombre,
            '*Teléfono:* '.$lead->telefono,
        ];

        if ($lead->email) {
            $lineas[] = '*Correo:* '.$lead->email;
        }
        if ($lead->empresa) {
            $lineas[] = '*Empresa:* '.$lead->empresa;
        }
        if ($lead->ciudad) {
            $lineas[] = '*Ciudad:* '.$lead->ciudad;
        }
        if ($lead->service) {
            $lineas[] = '*Servicio de interés:* '.$lead->interesLabel();
        }

        $lineas[] = '';
        $lineas[] = '¿Me ayudan con una cotización?';

        // Para el asesor: abre la ficha del prospecto en el panel (pide iniciar sesión)
        $lineas[] = '';
        $lineas[] = '_Ficha '.$lead->folio().':_ '.route('admin.leads.show', $lead);

        return implode("\n", $lineas);
    }

    public static function url(string $mensaje, ?string $numero = null): string
    {
        $numero = preg_replace('/\D+/', '', $numero ?? (string) config('services.whatsapp.numero'));

        return 'https://wa.me/'.$numero.'?text='.rawurlencode($mensaje);
    }
}
