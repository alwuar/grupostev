@php
    $a = config('stev.privacidad');
    $actualizado = \Carbon\Carbon::parse($a['actualizado'])->locale('es')->translatedFormat('j \d\e F \d\e Y');
@endphp
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aviso de privacidad | Grupo STEV Seguridad Privada</title>
    <meta name="description" content="Aviso de privacidad de Grupo STEV Seguridad Privada: qué datos personales recabamos, para qué los usamos y cómo ejercer tus derechos ARCO.">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <meta name="theme-color" content="#0d0e0e">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/scss/legal.scss'])
</head>
<body class="legal">
    <header class="legal__barra">
        <div class="legal__contenedor legal__barra-fila">
            <a href="{{ route('home') }}" aria-label="Grupo STEV, ir al inicio">
                <img src="{{ asset('img/logo-orange.svg') }}" alt="Grupo STEV Seguridad Privada" width="120">
            </a>
            <a href="{{ route('home') }}" class="legal__volver">← Volver al sitio</a>
        </div>
    </header>

    <main class="legal__contenedor legal__cuerpo">
        <h1>Aviso de privacidad</h1>
        <p class="legal__fecha">Última actualización: {{ $actualizado }}</p>

        <h2>1. Responsable de tus datos</h2>
        <p>
            <strong>{{ $a['responsable'] }}</strong> (en adelante, “Grupo STEV”), con domicilio en {{ $a['domicilio'] }},
            es responsable del uso y protección de tus datos personales, conforme a la Ley Federal de Protección de
            Datos Personales en Posesión de los Particulares y demás normativa aplicable.
        </p>
        <p>Para cualquier asunto relacionado con tus datos personales puedes escribirnos a
            <a href="mailto:{{ $a['correo'] }}">{{ $a['correo'] }}</a> o llamarnos al {{ $a['telefono'] }}.</p>

        <h2>2. Datos personales que recabamos</h2>
        <p>Cuando llenas el formulario de contacto de este sitio o nos escribes por WhatsApp, recabamos:</p>
        <ul>
            <li>Nombre y apellido.</li>
            <li>Número de teléfono.</li>
            <li>Correo electrónico (opcional).</li>
            <li>Empresa y ciudad.</li>
            <li>El servicio que te interesa (traslado de valores, recolección de efectivo, custodia de valores u otro).</li>
        </ul>
        <p>
            Además, de forma automática registramos la dirección IP desde la que se envió el formulario y la fecha y hora
            del envío, para prevenir envíos fraudulentos o automatizados.
        </p>
        <p><strong>No recabamos datos personales sensibles</strong> ni datos financieros a través de este sitio.</p>

        <h2>3. ¿Para qué usamos tus datos?</h2>
        <p>Usaremos tus datos para las siguientes <strong>finalidades necesarias</strong> para atender tu solicitud:</p>
        <ul>
            <li>Contactarte por WhatsApp, llamada o correo electrónico para responder tu solicitud de información.</li>
            <li>Identificar las necesidades de seguridad de tu operación y proponerte la solución adecuada.</li>
            <li>Enviarte cotizaciones y dar seguimiento a tu solicitud.</li>
            <li>En su caso, preparar la contratación del servicio.</li>
        </ul>
        <p>De manera adicional, usaremos tu información para las siguientes <strong>finalidades secundarias</strong>,
            que no son necesarias para atender tu solicitud pero nos ayudan a brindarte un mejor servicio:</p>
        <ul>
            <li>Enviarte información, promociones y novedades de Grupo STEV.</li>
            <li>Elaborar estadísticas internas sobre cómo nos conocen nuestros clientes y la calidad de nuestra atención.</li>
        </ul>
        <p>
            Si no deseas que tus datos se usen para las finalidades secundarias, escríbenos a
            <a href="mailto:{{ $a['correo'] }}?subject=No%20deseo%20finalidades%20secundarias">{{ $a['correo'] }}</a>
            indicando tu nombre y teléfono. Negarte a estas finalidades no será motivo para dejar de atenderte.
        </p>

        <h2>4. ¿Con quién compartimos tus datos?</h2>
        <p>
            Tus datos <strong>no se venden ni se comparten</strong> con terceros para fines propios de ellos.
            Únicamente los conocen el personal de Grupo STEV que atiende tu solicitud y los proveedores que nos prestan
            servicios tecnológicos necesarios (por ejemplo, alojamiento del sitio web y mensajería), quienes están
            obligados a tratarlos solo por cuenta de Grupo STEV y a mantener su confidencialidad.
        </p>
        <p>Podremos comunicar tus datos a autoridades cuando una ley o un mandato de autoridad competente así lo exija.</p>

        <h2>5. Tus derechos ARCO</h2>
        <p>
            Tienes derecho a conocer qué datos tenemos de ti y para qué los usamos (<strong>Acceso</strong>), a pedir que los
            corrijamos si son incorrectos (<strong>Rectificación</strong>), a que los eliminemos de nuestros registros cuando
            consideres que no se están usando conforme a la ley (<strong>Cancelación</strong>) y a oponerte a su uso para fines
            específicos (<strong>Oposición</strong>).
        </p>
        <p>Para ejercerlos, envía un correo a <a href="mailto:{{ $a['correo'] }}?subject=Solicitud%20de%20derechos%20ARCO">{{ $a['correo'] }}</a> con:</p>
        <ul>
            <li>Tu nombre completo y un medio para responderte.</li>
            <li>Una copia de una identificación oficial (o, en su caso, de la representación legal).</li>
            <li>La descripción clara de los datos y del derecho que deseas ejercer.</li>
        </ul>
        <p>Te responderemos en un plazo máximo de 20 días hábiles contados desde que recibamos tu solicitud completa.</p>

        <h2>6. Revocación del consentimiento</h2>
        <p>
            Puedes revocar en cualquier momento el consentimiento que nos diste para el uso de tus datos, siguiendo el
            mismo procedimiento del punto anterior. Ten en cuenta que, si la revocación impide atender tu solicitud,
            no podremos seguir dándote seguimiento.
        </p>
        <p>Si no quieres recibir más mensajes, también puedes pedírnoslo directamente por WhatsApp o en cualquier respuesta a nuestros correos.</p>

        <h2>7. Cookies y tecnologías similares</h2>
        <p>
            Este sitio usa cookies técnicas indispensables para su funcionamiento y seguridad (por ejemplo, para proteger
            el formulario de envíos falsos). Estas cookies no se usan para identificarte ni con fines publicitarios.
            Puedes deshabilitarlas desde la configuración de tu navegador, aunque algunas funciones del sitio podrían
            dejar de funcionar.
        </p>

        <h2>8. Cambios a este aviso</h2>
        <p>
            Este aviso puede modificarse por cambios en la ley, en nuestros servicios o en nuestras prácticas.
            Cualquier cambio se publicará en esta misma página, indicando la fecha de la última actualización.
        </p>

        <h2>9. ¿Ante quién puedes acudir?</h2>
        <p>
            Si consideras que tu derecho a la protección de datos personales ha sido vulnerado, puedes acudir ante la
            autoridad competente en materia de protección de datos personales.
        </p>

        <p class="legal__consentimiento">
            Al marcar la casilla de autorización en el formulario de contacto, manifiestas que leíste este aviso de
            privacidad y que estás de acuerdo con el uso de tus datos en los términos aquí descritos.
        </p>
    </main>

    <footer class="legal__pie">
        <div class="legal__contenedor">
            © {{ date('Y') }} Grupo STEV Seguridad Privada · <a href="{{ route('home') }}">Volver al sitio</a>
        </div>
    </footer>
</body>
</html>
