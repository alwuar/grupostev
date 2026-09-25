@push('scss')
    @vite(['resources/scss/app.scss', 'resources/scss/welcome.scss', 'resources/js/app.js'])
@endpush

<x-layouts.guest>

    <header class="header">
        <div class="container">
            <video src="{{ asset('video/hangar-stev.webm') }}" class="header__video" autoplay loop muted></video>
            <div class="titular">
                <div class="titular__contenido">
                    <h1 class="text-white">Soluciones Integrales en Seguridad de Valores</h1>
                    <p class="text-white">Elevamos el estándar de protección con tecnología de monitoreo avanzado y diseñamos arquitecturas
                        de seguridad adaptadas a la escala real de tu negocio.</p>
                    <div class="botones">
                        <a href="" class="btn btn-primary">CONVIÉRTETE EN CLIENTE <span>-></span></a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="nosotros">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <x-info>
                        <x-slot name="titulo_info">
                            <h3>Nuestra esencia</h3>
                        </x-slot>
                        <x-slot name="descripcion_info">
                            En STEV Seguridad Privada protegemos lo que impulsa a tu negocio. Ofrecemos servicios
                            especializados de traslado, custodia y recolección de valores, combinando experiencia
                            operativa, tecnología y atención personalizada para responder a las necesidades de cada
                            empresa.
                        </x-slot>
                        <x-slot name="datos_info">
                            <x-layouts.highlight>
                                <x-slot name="icon">
                                    <img src="{{ asset('img/shield.svg') }}" width="20" alt="icono escudo">
                                </x-slot>
                                <x-slot name="info">
                                    Seguridad
                                </x-slot>
                            </x-layouts.highlight>
                            <x-layouts.highlight>
                                <x-slot name="icon">
                                    <img src="{{ asset('img/shield.svg') }}" width="20" alt="icono escudo">
                                </x-slot>
                                <x-slot name="info">
                                    Compromiso
                                </x-slot>
                            </x-layouts.highlight>
                            <x-layouts.highlight>
                                <x-slot name="icon">
                                    <img src="{{ asset('img/shield.svg') }}" width="20" alt="icono escudo">
                                </x-slot>
                                <x-slot name="info">
                                    Disponiibilidad
                                </x-slot>
                            </x-layouts.highlight>
                            <x-layouts.highlight>
                                <x-slot name="icon">
                                    <img src="{{ asset('img/shield.svg') }}" width="20" alt="icono escudo">
                                </x-slot>
                                <x-slot name="info">
                                    Confianza
                                </x-slot>
                            </x-layouts.highlight>
                        </x-slot>
                    </x-info>

                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <video src="{{ asset ('/video/camioneta-gpo-stev.webm') }}" autoplay loop mute></video>
                </div>
            </div>
        </div>
    </section>

    <section class="valores">
        <div class="container">
            <h2>Movemos valores, protegemos confianza</h2>
            <div class="bullets">
                <x-mvvalores>
                    <x-slot name="icono">
                        <img src="{{ asset('img/shield.svg') }}" width="30" alt="icono escudo">
                    </x-slot>
                    <x-slot name="titulo">
                        Misión
                    </x-slot>
                    <x-slot name="texto">
                        Proteger el patrimonio de nuestros clientes mediante servicios de traslado, custodia y
                        recolección de valores, ejecutados con disciplina, tecnología y un compromiso permanente con la
                        seguridad.
                    </x-slot>
                </x-mvvalores>
                <x-mvvalores>
                    <x-slot name="icono">
                        <img src="{{ asset('img/EyeOutline.svg') }}" width="30" alt="icono escudo">
                    </x-slot>
                    <x-slot name="titulo">
                        Visión
                    </x-slot>
                    <x-slot name="texto">
                        Ser un referente nacional en seguridad y traslado de valores, reconocidos por nuestra
                        innovación, cercanía con el cliente y excelencia operativa. <br><br>
                    </x-slot>
                </x-mvvalores>
                <x-mvvalores>
                    <x-slot name="icono">
                        <img src="{{ asset('img/FlagOutline.svg') }}" width="30" alt="icono escudo">
                    </x-slot>
                    <x-slot name="titulo">
                        Objetivo
                    </x-slot>
                    <x-slot name="texto">
                        Consolidarnos como una empresa de seguridad privada confiable y eficiente, ofreciendo soluciones
                        que protejan el capital de nuestros clientes y contribuyan a la continuidad de sus operaciones.
                    </x-slot>
                </x-mvvalores>
            </div>
        </div>
    </section>

    <section class="servicios">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">

                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <small class="oferta">Oferta de Servicios</small>
                    <x-info>
                        <x-slot name="titulo_info">
                            <h3>Soluciones de Seguridad a la Medida de tu Operación</h3>
                        </x-slot>
                        <x-slot name="descripcion_info">
                            <p>Cada empresa tiene necesidades distintas. Diseñamos soluciones de traslado, custodia y
                                recolección de efectivo adaptadas a tu volumen de operación, frecuencia y requerimientos
                                de seguridad, con procesos confiables y atención especializada.
                            </p>
                        </x-slot>
                        <x-slot name="datos_info">
                            <x-layouts.highlight>
                                <x-slot name="icon">
                                    <img src="{{ asset('img/shield.svg') }}" width="20" alt="icono escudo">
                                </x-slot>
                                <x-slot name="info">
                                    Traslado de valores
                                </x-slot>
                            </x-layouts.highlight>
                            <x-layouts.highlight>
                                <x-slot name="icon">
                                    <img src="{{ asset('img/shield.svg') }}" width="20" alt="icono escudo">
                                </x-slot>
                                <x-slot name="info">
                                    Movimiento de efectivo
                                </x-slot>
                            </x-layouts.highlight>
                            <x-layouts.highlight>
                                <x-slot name="icon">
                                    <img src="{{ asset('img/shield.svg') }}" width="20" alt="icono escudo">
                                </x-slot>
                                <x-slot name="info">
                                    Custodia de valores
                                </x-slot>
                            </x-layouts.highlight>

                        </x-slot>
                    </x-info>

                </div>
            </div>
        </div>
    </section>

    <section class="galeria">
        <div>
            <img src="{{ asset('img/images/1.jpg') }}" alt="" class="content">
        </div>
        <div>
            <img src="{{ asset('img/images/4.jpg') }}" alt="" class="content">
        </div>
        <div>
            <img src="{{ asset('img/images/2.jpg') }}" alt="" class="content">
        </div>
        <div>
            <img src="{{ asset('img/images/3.jpg') }}" alt="" class="content">
        </div>

    </section>

    <section class="valor-agregado">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <h3>¿Porqué elegirnos?</h3>
                    <p>
                        Eliminamos los procesos lentos del modelo transnacional tradicional para ofrecerte una
                        plataforma logística flexible, dinámica y enfocada en tus objetivos.
                    </p>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <ul>
                        <li>
                            <span>
                                <img src="{{ asset('/img/check.svg') }}" width="20" alt="checklist">
                            </span><strong style="padding-left: 10px">Atención personalizada</strong> <br>
                            Enlace directo con especialistas en resolución inmediata.
                        </li>
                        <li>
                            <span>
                                <img src="{{ asset('/img/check.svg') }}" width="20" alt="checklist">
                            </span><strong style="padding-left: 10px">Tiempos de respuesta flexibles</strong><br>
                            Logística adaptada a la dinámica real de tu flujo de trabajo.
                        </li>
                        <li>
                            <span>
                                <img src="{{ asset('/img/check.svg') }}" width="20" alt="checklist">
                            </span><strong style="padding-left: 10px">Eficiencia de costos</strong><br>
                            Precios disruptivos que cuidan tu margen operativo garantizando máxima protección
                            tecnológica y física.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="cobertura">
        <div class="container">
            <div class="titular">
                <h3>Tecnología de Vanguardia para la Protección de tus Valores</h3>
                <p>La seguridad de tu efectivo requiere preparación, control y tecnología. Contamos con unidades
                    especializadas, sistemas de monitoreo y personal capacitado para fortalecer la protección durante
                    cada operación.</p>
            </div>
            <div class="bullets">
                <div class="contenedor">
                    <x-layouts.highlight>
                        <x-slot name="icon">
                            <img src="{{ asset('img/ShieldCheckOutline.svg') }}" width="20" alt="">
                        </x-slot>
                        <x-slot name="info">
                            Blindaje Certificado Nivel 4 PLUS
                        </x-slot>
                    </x-layouts.highlight>
                    <x-layouts.highlight>
                        <x-slot name="icon">
                            <img src="{{ asset('img/ShieldCheckOutline.svg') }}" width="20" alt="">
                        </x-slot>
                        <x-slot name="info">
                            Telemetría y Video-Vigilancia 360°
                        </x-slot>
                    </x-layouts.highlight>
                    <x-layouts.highlight>
                        <x-slot name="icon">
                            <img src="{{ asset('img/ShieldCheckOutline.svg') }}" width="20" alt="">
                        </x-slot>
                        <x-slot name="info">
                            Rastreo Satelital en Tiempo Real
                        </x-slot>
                    </x-layouts.highlight>
                </div>
                <div class="contenedor">
                    <x-layouts.highlight>
                        <x-slot name="icon">
                            <img src="{{ asset('img/ShieldCheckOutline.svg') }}" width="20" alt="">
                        </x-slot>
                        <x-slot name="info">
                            Telemetría y Video-Vigilancia 360°
                        </x-slot>
                    </x-layouts.highlight>
                    <x-layouts.highlight>
                        <x-slot name="icon">
                            <img src="{{ asset('img/ShieldCheckOutline.svg') }}" width="20" alt="">
                        </x-slot>
                        <x-slot name="info">
                            Rastreo Satelital en Tiempo Real
                        </x-slot>
                    </x-layouts.highlight>
                </div>
            </div>
        </div>
    </section>

    <section class="mapa">
        <div class="container">
            <div class="mapa__contenido">
                <img src="{{ asset('img/mexico-mapa-1.png') }}" class="img-fluid" alt="Mapa de presencia">
                <div class="mapa__contenido__info">
                    <span>Nuestra presencia</span>
                    <h4>Más cerca de tu negocio</h4>
                    <p>Operamos en puntos estratégicos en México para brindarte soluciones de traslado, custodia y recolección de valores con la seguridad y confianza que tu empresa necesita.</p>
                </div>
            </div>
        </div>
    </section>
    <div class="form">
        <div class="container">
            <div class="titular">
                <h4>Protege el Efectivo de tu Empresa Hoy Mismo</h4>
                <p>Cuéntanos qué necesita tu operación. Un especialista de STEV te ayudará a diseñar una solución de traslado, custodia o recolección de valores adaptada a tu empresa.</p>
            </div>
        </div>
    </div>

</x-layouts.guest>
