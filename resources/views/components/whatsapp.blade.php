{{-- Botón fijo de WhatsApp en celular: abre la ventana de contacto (sin JavaScript va directo a WhatsApp) --}}
<a href="{{ \App\Support\WhatsAppMessage::url('Hola, quiero información sobre sus servicios de seguridad') }}"
   class="btn btn-primary whatsapp-btn" target="_blank" rel="noopener"
   data-abrir-contacto data-origen="boton-flotante"
   aria-haspopup="dialog" aria-controls="modal-contacto">
    Hablar por WhatsApp
</a>
