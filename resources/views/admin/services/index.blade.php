<x-admin.layout title="Servicios">

    <div class="page-head">
        <div>
            <h1>Servicios</h1>
            <p class="sub">Opciones de "Servicio de interés" que aparecen en el formulario del sitio.</p>
        </div>
    </div>

    @if ($errors->any() && ! $errors->has('nombre'))
        <div class="alert alert-warning">Revisa los servicios marcados: todos necesitan nombre.</div>
    @endif

    <form method="POST" action="{{ route('admin.services.update') }}" novalidate>
        @csrf
        @method('PUT')

        <div class="tabla-wrap">
            <table class="table tabla-leads tabla-simple">
                <thead>
                    <tr>
                        <th scope="col">Servicio</th>
                        <th scope="col" class="text-end">Prospectos</th>
                        <th scope="col">En el formulario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($servicios as $s)
                        <tr @class(['fila-inactiva' => ! $s->activo])>
                            <td data-label="Servicio" class="td-nombre">
                                <label for="s{{ $s->id }}-nombre" class="visually-hidden">Nombre</label>
                                <input type="text" id="s{{ $s->id }}-nombre" name="servicios[{{ $s->id }}][nombre]"
                                       value="{{ old("servicios.$s->id.nombre", $s->nombre) }}" maxlength="100"
                                       class="form-control form-control-sm @error("servicios.$s->id.nombre") is-invalid @enderror">
                                @error("servicios.$s->id.nombre")<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </td>
                            <td data-label="Prospectos" class="text-end">{{ $s->leads_count }}</td>
                            <td data-label="En el formulario">
                                <div class="form-check form-switch m-0">
                                    <input type="hidden" name="servicios[{{ $s->id }}][activo]" value="0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="s{{ $s->id }}-activo"
                                           name="servicios[{{ $s->id }}][activo]" value="1" @checked(old("servicios.$s->id.activo", $s->activo))>
                                    <label class="form-check-label small" for="s{{ $s->id }}-activo">Visible</label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-mx">Guardar servicios</button>
        </div>
    </form>

    <form method="POST" action="{{ route('admin.services.store') }}" class="mx-card mt-4" novalidate>
        @csrf
        <div class="mx-card__title">Agregar servicio</div>
        <div class="row g-2 align-items-start">
            <div class="col">
                <label for="nuevo-nombre" class="visually-hidden">Nombre del servicio</label>
                <input type="text" name="nombre" id="nuevo-nombre" value="{{ old('nombre') }}" maxlength="100"
                       placeholder="Ej. Monitoreo de unidades" class="form-control @error('nombre') is-invalid @enderror">
                @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12 col-sm-auto">
                <button type="submit" class="btn btn-mx-outline w-100">Agregar</button>
            </div>
        </div>
        <p class="small text-secondary mt-2 mb-0">"Visible" controla si aparece como opción en el formulario del sitio. Apagarlo no borra los prospectos que ya lo eligieron.</p>
    </form>

</x-admin.layout>
