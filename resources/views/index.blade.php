@push('scss')
    @vite(['resources/scss/app.scss', 'resources/scss/welcome.scss', 'resources/js/app.js'])
@endpush

<x-layouts.guest>

    <header class="header">
        <div class="container">
            <div class="titular">
                <div class="titular__contenido">
                    <h1>Soluciones Integrales en Seguridad de Valores</h1>
                    <p>Elevamos el estándar de protección con tecnología de monitoreo avanzado y diseñamos arquitecturas
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
                            <p>Cada empresa tiene necesidades distintas. Diseñamos soluciones de traslado, custodia y recolección de efectivo adaptadas a tu volumen de operación, frecuencia y requerimientos de seguridad, con procesos confiables y atención especializada.
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

</x-layouts.guest>
