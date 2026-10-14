<?php

namespace App\Http\Controllers;

use App\Enums\ActivityType;
use App\Enums\LeadStatus;
use App\Models\Lead;
use App\Notifications\NuevoProspecto;
use App\Support\WhatsAppMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Recibe el formulario del sitio: guarda al prospecto, avisa por correo
 * y lo manda a WhatsApp con el mensaje ya escrito.
 */
class LeadController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // Campo trampa: los humanos no lo ven, los bots lo llenan
        if ($request->filled('sitio_web')) {
            return redirect()->away(WhatsAppMessage::url('Hola, quiero información sobre sus servicios de seguridad'));
        }

        $validator = Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'min:3', 'max:120'],
            'telefono' => ['required', 'string', 'max:30', 'regex:/^[\d\s\-\+\(\)]{10,}$/'],
            'email' => ['nullable', 'email', 'max:150'],
            'empresa' => ['nullable', 'string', 'max:150'],
            'ciudad' => ['nullable', 'string', 'max:120'],
            'service_id' => ['nullable', Rule::exists('services', 'id')->where('activo', true)],
            'consentimiento' => ['accepted'],
            'origen' => ['nullable', 'string'],
        ], [
            'telefono.regex' => 'Escribe un teléfono válido de 10 dígitos.',
            'consentimiento.accepted' => 'Necesitamos tu autorización para poder contactarte.',
        ], [
            'nombre' => 'nombre',
            'telefono' => 'teléfono',
            'email' => 'correo',
            'empresa' => 'empresa',
            'ciudad' => 'ciudad',
            'service_id' => 'servicio de interés',
        ]);

        // Si llega un origen desconocido se toma como formulario de la página
        $origen = array_key_exists((string) $request->input('origen'), Lead::ORIGENES)
            ? $request->input('origen')
            : 'formulario-web';

        if ($validator->fails()) {
            // Desde la ventana emergente se regresa arriba y la ventana se vuelve a abrir
            $destino = $origen === 'formulario-web' ? url('/').'#contacto' : url('/');

            return redirect()->to($destino)
                ->withErrors($validator, 'contacto')
                ->withInput();
        }

        $datos = $validator->validated();

        $lead = DB::transaction(function () use ($datos, $request, $origen) {
            $lead = Lead::create([
                'nombre' => trim($datos['nombre']),
                'telefono' => trim($datos['telefono']),
                'email' => $datos['email'] ?? null,
                'empresa' => isset($datos['empresa']) ? trim($datos['empresa']) : null,
                'ciudad' => isset($datos['ciudad']) ? trim($datos['ciudad']) : null,
                'service_id' => $datos['service_id'] ?? null,
                'estado' => LeadStatus::Recibido,
                'origen' => $origen,
                'consentimiento_at' => now(),
                'ip' => $request->ip(),
            ]);

            $lead->activities()->create([
                'tipo' => ActivityType::Sistema,
                'estado' => LeadStatus::Recibido,
                'asunto' => 'Solicitud recibida desde la web',
                'nota' => 'El prospecto llenó el formulario y fue enviado a WhatsApp.',
            ]);

            return $lead;
        });

        $this->avisarPorCorreo($lead);

        return redirect()->away(WhatsAppMessage::url(WhatsAppMessage::forLead($lead)));
    }

    /**
     * Manda el aviso a los correos de PROSPECTOS_CORREO. Se envía después de
     * mandar al prospecto a WhatsApp, así no espera al correo; y si el correo
     * falla, el prospecto ya quedó guardado y el error va al log.
     */
    private function avisarPorCorreo(Lead $lead): void
    {
        $correos = config('stev.prospectos.correos');

        if (empty($correos)) {
            return;
        }

        defer(function () use ($lead, $correos) {
            try {
                Notification::route('mail', $correos)->notify(new NuevoProspecto($lead));
            } catch (\Throwable $e) {
                report($e);
            }
        });
    }
}
