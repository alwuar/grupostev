  <div class="form pb-5 scroll-animate" id="contacto">
        <div class="bg-tiger-right">
            <img src="{{ asset('img/images/tiger-bg-r.svg') }}" width="850" alt="">
        </div>
        <div class="container ">
            <div class="titular">
                <h4>Protege el efectivo de tu empresa hoy mismo</h4>
                <p>Cuéntanos qué necesita tu operación. Un especialista de STEV te ayudará a diseñar una solución de
                    traslado, custodia o recolección de valores adaptada a tu empresa.</p>
            </div>
            <form class="row g-3 formulario" method="POST" action="{{ route('leads.store') }}" novalidate>
                <x-contacto.campos modo="seccion" />
            </form>
        </div>
    </div>