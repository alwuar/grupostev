{{--
    Campos del formulario de contacto. Se usa en la sección #contacto
    y en la ventana emergente de los botones de WhatsApp.
    - $modo: 'seccion' o 'modal' (cambia ids y dónde se muestran los errores)
--}}
@props(['modo' => 'seccion'])

@php
    $p = $modo === 'modal' ? 'm-' : '';               // prefijo de ids para no repetirlos
    $origenEnviado = old('origen');
    $esModalEnviado = $origenEnviado && $origenEnviado !== 'formulario-web';

    // Los errores y valores previos solo se muestran en el formulario que se envió
    $esEste = $modo === 'modal' ? $esModalEnviado : ! $esModalEnviado;
    $errores = $esEste ? $errors->getBag('contacto') : new \Illuminate\Support\MessageBag;
    $val = fn (string $campo) => $esEste ? old($campo) : null;

    $servicios = \App\Models\Service::activos()->get(['id', 'nombre']);
    $origenDefecto = $modo === 'modal' ? ($esModalEnviado ? $origenEnviado : 'boton-flotante') : 'formulario-web';
@endphp

@csrf
<input type="hidden" name="origen" value="{{ $origenDefecto }}" data-campo-origen>

{{-- Campo trampa contra bots: no lo llenes --}}
<div class="form-trampa" aria-hidden="true">
    <label for="{{ $p }}sitio_web">Sitio web</label>
    <input type="text" name="sitio_web" id="{{ $p }}sitio_web" tabindex="-1" autocomplete="off">
</div>

<div class="form_contenido">
    @if ($errores->any())
        <div class="alert alert-warning mb-0" role="alert">
            Revisa los campos marcados para poder enviarte a WhatsApp.
        </div>
    @endif

    <div class="col-md-12 pb-3">
        <label for="{{ $p }}nombre" class="visually-hidden">Nombre y apellido</label>
        <input type="text" name="nombre" placeholder="NOMBRE Y APELLIDO" autocomplete="name" required
               value="{{ $val('nombre') }}" data-campo-nombre
               class="form-control @if($errores->has('nombre')) is-invalid @endif" id="{{ $p }}nombre">
        @if($errores->has('nombre'))<div class="invalid-feedback">{{ $errores->first('nombre') }}</div>@endif
    </div>
    <div class="row">
        <div class="col-md-6 pb-3">
            <label for="{{ $p }}telefono" class="visually-hidden">Teléfono</label>
            <input type="tel" name="telefono" placeholder="TELÉFONO" autocomplete="tel" inputmode="tel" required
                   value="{{ $val('telefono') }}"
                   class="form-control @if($errores->has('telefono')) is-invalid @endif" id="{{ $p }}telefono">
            @if($errores->has('telefono'))<div class="invalid-feedback">{{ $errores->first('telefono') }}</div>@endif
        </div>
        <div class="col-md-6 pb-3">
            <label for="{{ $p }}email" class="visually-hidden">Correo electrónico</label>
            <input type="email" name="email" placeholder="EMAIL" autocomplete="email"
                   value="{{ $val('email') }}"
                   class="form-control @if($errores->has('email')) is-invalid @endif" id="{{ $p }}email">
            @if($errores->has('email'))<div class="invalid-feedback">{{ $errores->first('email') }}</div>@endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 pb-3">
            <label for="{{ $p }}empresa" class="visually-hidden">Empresa</label>
            <input type="text" name="empresa" placeholder="EMPRESA" autocomplete="organization"
                   value="{{ $val('empresa') }}"
                   class="form-control @if($errores->has('empresa')) is-invalid @endif" id="{{ $p }}empresa">
            @if($errores->has('empresa'))<div class="invalid-feedback">{{ $errores->first('empresa') }}</div>@endif
        </div>
        <div class="col-md-6 pb-3">
            <label for="{{ $p }}ciudad" class="visually-hidden">Ciudad</label>
            <input type="text" name="ciudad" placeholder="CIUDAD" autocomplete="address-level2"
                   value="{{ $val('ciudad') }}"
                   class="form-control @if($errores->has('ciudad')) is-invalid @endif" id="{{ $p }}ciudad">
            @if($errores->has('ciudad'))<div class="invalid-feedback">{{ $errores->first('ciudad') }}</div>@endif
        </div>
    </div>
    @if ($servicios->isNotEmpty())
        <div class="col-md-12 pb-3">
            <label for="{{ $p }}service_id" class="visually-hidden">¿Qué servicio te interesa?</label>
            <select name="service_id" id="{{ $p }}service_id"
                    class="form-select @if($errores->has('service_id')) is-invalid @endif">
                <option value="" @selected(! $val('service_id'))>SERVICIO DE INTERÉS (OPCIONAL)</option>
                @foreach ($servicios as $serv)
                    <option value="{{ $serv->id }}" @selected((string) $val('service_id') === (string) $serv->id)>{{ mb_strtoupper($serv->nombre) }}</option>
                @endforeach
            </select>
            @if($errores->has('service_id'))<div class="invalid-feedback">{{ $errores->first('service_id') }}</div>@endif
        </div>
    @endif
    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input @if($errores->has('consentimiento')) is-invalid @endif"
                   type="checkbox" name="consentimiento" value="1" id="{{ $p }}consentimiento" required
                   @checked($val('consentimiento'))>
            <label class="form-check-label " for="{{ $p }}consentimiento">
                Autorizo a Grupo STEV a contactarme por WhatsApp, llamada o correo electrónico para
                brindarme información sobre sus servicios. He leído el
                <a href="{{ route('aviso-privacidad') }}" target="_blank" rel="noopener" class="enlace-aviso">aviso de privacidad</a>.
            </label>
            @if($errores->has('consentimiento'))<div class="invalid-feedback">{{ $errores->first('consentimiento') }}</div>@endif
        </div>
    </div>
    <div class="col-12 mt-2" style="display: flex; flex-direction: row; justify-content: center; align-items: center">
        <button type="submit" class="btn btn-primary arrow btn-block">
            SOLICITAR INFORMACIÓN <span>
                <img src="{{ asset('/img/images/Arrow.svg') }}" width="18" alt="">
            </span>
        </button>
    </div>
    @if ($modo === 'seccion')
        <div class="col-12 text-center mt-2">Recibirás comunicaciones por parte de nuestros asesores para
            brindarte atención completa y personalizada, además de correos electrónicos con fines
            informativos.
        </div>
    @endif
</div>
