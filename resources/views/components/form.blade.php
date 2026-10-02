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
            <form class="row g-3 formulario">
                <div class="form_contenido">
                    <div class="col-md-12 pb-3">
                        <input type="name" placeholder="NOMBRE Y APELLIDO" class="form-control" id="name">
                    </div>
                    <div class="row">
                        <div class="col-md-6 pb-3">
                            <input type="tel" placeholder="TELÉFONO" class="form-control" id="tel">
                        </div>
                        <div class="col-md-6">
                            <input type="email" placeholder="EMAIL" class="form-control" id="email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 pb-3">
                            <input type="text" placeholder="EMPRESA" class="form-control" id="empresa">
                        </div>
                        <div class="col-md-6">
                            <input type="text" placeholder="CIUDAD" class="form-control" id="ciudad">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label " for="gridCheck">
                                Autorizo a Grupo STEV a contactarme por WhatsApp, llamada o correo electrónico para
                                brindarme información sobre sus servicios.
                            </label>
                        </div>
                    </div>
                    <div class="col-12 mt-2" style="display: flex; flex-direction: row; justify-content: center; align-items: center">
                        <button type="submit" class="btn btn-primary arrow btn-block">
                            SOLICITAR INFORMACIÓN <span>
                                <img src="{{ asset('/img/images/Arrow.svg') }}" width="18" alt="">
                            </span>
                        </button>
                    </div>
                    <div class="col-12 text-center mt-2">Recibirás comunicaciones por parte de nuestros asesores para
                        brindarte atención completa y personalizada, además de correos electrónicos con fines
                        informativos.
                    </div>
                </div>
            </form>
        </div>
    </div>