{{-- Versión de solo texto (sin HTML): por eso se imprime sin escapar --}}
NUEVO PROSPECTO · {{ $lead->folio() }}
{!! $lead->nombre !!}

@foreach ($datos as $campo => $valor)
{!! $campo !!}: {!! $valor !!}
@endforeach

Ver en el panel: {{ $urlPanel }}
Escribirle por WhatsApp: {{ $urlWhatsApp }}

--
Desarrollado por agenciavandu.com
¿Necesitas una funcionalidad nueva? Platica con un asesor: {{ $urlVandu }}
