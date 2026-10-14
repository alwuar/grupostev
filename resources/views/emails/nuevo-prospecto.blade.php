{{--
    Correo de aviso de nuevo prospecto (HTML).
    Hecho con tablas y estilos en línea para que se vea bien en Gmail, Outlook y celular.
--}}
@php
    // Al enviarse, el logo va incrustado en el correo; en la vista previa se usa la URL pública
    $logo = isset($message)
        ? $message->embed(public_path('img/email/stev-logo.png'))
        : asset('img/email/stev-logo.png');

    $azul = '#EE8100';   // naranja STEV (botones y enlaces)
    $oscuro = '#2A3B47';
    $negro = '#0d0e0e';
    $gris = '#6B7680';
    $linea = '#E7EBEF';
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>Nuevo prospecto {{ $lead->folio() }}</title>
</head>
<body style="margin:0; padding:0; background-color:#F2F4F7; -webkit-text-size-adjust:100%;">

    {{-- Texto que algunos correos muestran junto al asunto --}}
    <div style="display:none; max-height:0; overflow:hidden; opacity:0; mso-hide:all;">
        {{ $lead->nombre }}@if($lead->empresa) · {{ $lead->empresa }}@endif · {{ $lead->interesLabel() ?? 'Servicio por definir' }}
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#F2F4F7;">
        <tr>
            <td align="center" style="padding:32px 12px;">

                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;">

                    {{-- Tarjeta --}}
                    <tr>
                        <td style="background-color:#FFFFFF; border-radius:14px; border-top:5px solid {{ $azul }}; overflow:hidden;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">

                                {{-- Logo --}}
                                <tr>
                                    <td align="center" bgcolor="{{ $negro }}" style="padding:24px 32px; background-color:{{ $negro }};">
                                        <img src="{{ $logo }}" width="170" alt="Grupo STEV"
                                             style="display:block; width:170px; max-width:170px; height:auto; border:0; outline:none; text-decoration:none;">
                                    </td>
                                </tr>

                                {{-- Encabezado --}}
                                <tr>
                                    <td align="center" style="padding:28px 32px 4px; font-family:Arial, Helvetica, sans-serif;">
                                        <span style="display:inline-block; padding:6px 14px; border-radius:999px; background-color:#FFF1DC; color:#9A5200; font-size:12px; font-weight:bold; letter-spacing:1px; text-transform:uppercase;">
                                            Nuevo prospecto
                                        </span>
                                        <h1 style="margin:16px 0 6px; color:{{ $oscuro }}; font-size:26px; line-height:1.25; font-weight:bold;">
                                            {{ $lead->nombre }}
                                        </h1>
                                        <p style="margin:0; color:{{ $gris }}; font-size:14px; line-height:1.5;">
                                            Folio <strong style="color:{{ $oscuro }};">{{ $lead->folio() }}</strong>
                                            @if ($fecha) &nbsp;·&nbsp; {{ $fecha }} @endif
                                        </p>
                                    </td>
                                </tr>

                                {{-- Datos --}}
                                <tr>
                                    <td style="padding:24px 32px 8px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                                               style="font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:1.45;">
                                            @foreach ($datos as $campo => $valor)
                                                <tr>
                                                    <td valign="top" width="42%"
                                                        style="padding:11px 12px 11px 0; color:{{ $gris }}; border-bottom:1px solid {{ $linea }};">
                                                        {{ $campo }}
                                                    </td>
                                                    <td valign="top"
                                                        style="padding:11px 0; color:{{ $oscuro }}; font-weight:bold; border-bottom:1px solid {{ $linea }}; word-break:break-word;">
                                                        @if ($campo === 'Teléfono')
                                                            <a href="tel:+{{ $lead->telefonoInternacional() }}" style="color:{{ $azul }}; text-decoration:none;">{{ $valor }}</a>
                                                        @elseif ($campo === 'Correo')
                                                            <a href="mailto:{{ $valor }}" style="color:{{ $azul }}; text-decoration:none;">{{ $valor }}</a>
                                                        @else
                                                            {{ $valor }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>

                                {{-- Botones --}}
                                <tr>
                                    <td align="center" style="padding:24px 32px 8px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;">
                                            <tr>
                                                <td align="center" bgcolor="{{ $azul }}" style="border-radius:10px;">
                                                    <a href="{{ $urlPanel }}" target="_blank"
                                                       style="display:inline-block; padding:14px 28px; font-family:Arial, Helvetica, sans-serif; font-size:15px; font-weight:bold; color:#FFFFFF; text-decoration:none; border-radius:10px;">
                                                        Ver en el panel
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin:12px auto 0;">
                                            <tr>
                                                <td align="center" style="border-radius:10px; border:2px solid {{ $azul }};">
                                                    <a href="{{ $urlWhatsApp }}" target="_blank"
                                                       style="display:inline-block; padding:12px 26px; font-family:Arial, Helvetica, sans-serif; font-size:15px; font-weight:bold; color:{{ $azul }}; text-decoration:none; border-radius:10px;">
                                                        Escribirle por WhatsApp
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                {{-- Nota --}}
                                <tr>
                                    <td align="center" style="padding:16px 32px 32px; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:1.5; color:{{ $gris }};">
                                        @if ($lead->email)
                                            Responde este correo para escribirle directo a {{ $lead->nombre }}.
                                        @else
                                            Al prospecto también se le abrió WhatsApp con su mensaje ya escrito.
                                        @endif
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                    {{-- Pie --}}
                    <tr>
                        <td align="center" style="padding:24px 16px 8px; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:1.6; color:{{ $gris }};">
                            Desarrollado por
                            <a href="https://agenciavandu.com" target="_blank" style="color:{{ $oscuro }}; font-weight:bold; text-decoration:none;">agenciavandu.com</a>
                            <br>
                            ¿Necesitas una funcionalidad nueva?
                            <a href="{{ $urlVandu }}" target="_blank" style="color:{{ $azul }}; text-decoration:underline;">Clic aquí para platicar con un asesor</a>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>
</body>
</html>
