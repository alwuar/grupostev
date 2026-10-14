@php
    use App\Support\LeadFilters;
    use App\Support\LeadStats;

    $s = $stats;
    $fmtPct = fn (?float $v) => $v === null ? '—' : rtrim(rtrim(number_format($v, 1), '0'), '.').'%';

    // Etapas del embudo (ancho relativo a los recibidos)
    $etapas = [
        ['nombre' => 'Recibidos', 'valor' => $s->total, 'clase' => 'etapa-1', 'ayuda' => 'Llenaron el formulario.'],
        ['nombre' => 'Contactados', 'valor' => $s->contactados, 'clase' => 'etapa-2', 'ayuda' => 'Un asesor habló con ellos.'],
        ['nombre' => 'Ganados', 'valor' => $s->ganados, 'clase' => 'etapa-3', 'ayuda' => 'Contrataron el servicio.'],
    ];

    // Fugas entre etapas
    $fuga1 = $s->sinContactar + $s->perdidosSinContacto;
    $fuga2 = $s->enSeguimiento + $s->perdidosTrasContacto;

    // Conclusión automática: ¿dónde se pierden más?
    $conclusion = null;
    if ($s->perdidos > 0) {
        $conclusion = $s->perdidosSinContacto >= $s->perdidosTrasContacto
            ? "La mayor pérdida está antes del primer contacto: {$s->perdidosSinContacto} de {$s->perdidos} perdidos nunca llegaron a hablar con un asesor. Responder más rápido es lo que más puede mejorar la tasa."
            : "La mayor pérdida está después del primer contacto: {$s->perdidosTrasContacto} de {$s->perdidos} perdidos sí hablaron con un asesor pero no cerraron. Conviene revisar la cotización, el seguimiento o la propuesta.";
    } elseif ($s->sinContactar > 0 && $s->total > 0) {
        $conclusion = "{$s->sinContactar} ".($s->sinContactar === 1 ? 'prospecto sigue' : 'prospectos siguen').' sin contactar. Entre más rápido se les escribe, más probable es cerrar.';
    }

    $desgloses = array_filter([
        'Por origen' => $s->porOrigen,
        'Por servicio de interés' => $s->porInteres,
    ]);
@endphp

<x-admin.layout title="Estadísticas">

    <div class="page-head">
        <div>
            <h1>Estadísticas</h1>
            <p class="sub">
                {{ LeadFilters::PERIODOS[$filtros->periodo] }}@if($filtros->rangoTexto()) · {{ $filtros->rangoTexto() }}@endif
            </p>
        </div>
    </div>

    {{-- ===== Filtros ===== --}}
    <form id="filtros" method="GET" action="{{ route('admin.stats.index') }}" class="mx-card mb-3">
        <div class="mx-card__title">Periodo</div>
        <div class="periodos mb-3" role="radiogroup" aria-label="Periodo">
            @foreach (LeadFilters::PERIODOS as $valor => $texto)
                <input type="radio" name="periodo" id="p-{{ $valor }}" value="{{ $valor }}" @checked($filtros->periodo === $valor)>
                <label for="p-{{ $valor }}">{{ $texto }}</label>
            @endforeach
        </div>
        <div class="row g-2 align-items-end">
            <div class="col-12 col-md-6 col-lg-5 rango-fechas" @if($filtros->periodo !== 'personalizado') hidden @endif>
                <div class="row g-2">
                    <div class="col-6">
                        <label for="desde" class="form-label small text-secondary mb-1">Desde</label>
                        <input type="date" name="desde" id="desde" class="form-control" value="{{ $filtros->desde?->toDateString() }}">
                    </div>
                    <div class="col-6">
                        <label for="hasta" class="form-label small text-secondary mb-1">Hasta</label>
                        <input type="date" name="hasta" id="hasta" class="form-control" value="{{ $filtros->hasta?->toDateString() }}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-auto rango-fechas" @if($filtros->periodo !== 'personalizado') hidden @endif>
                <button type="submit" class="btn btn-mx w-100">Aplicar</button>
            </div>
        </div>
    </form>

    @if ($s->total === 0)
        <div class="mx-card vacio">
            <h2>Aún no hay prospectos en este periodo</h2>
            <p class="mb-0">Prueba con otro periodo.</p>
        </div>
    @else

        {{-- ===== Indicadores ===== --}}
        <div class="kpis mb-3">
            <div class="kpi">
                <span class="kpi__label">Prospectos</span>
                <span class="kpi__valor">{{ number_format($s->total) }}</span>
                <span class="kpi__sub">{{ $s->sinContactar + $s->enSeguimiento }} en proceso</span>
            </div>
            <div class="kpi kpi--destacado">
                <span class="kpi__label">Tasa de éxito</span>
                <span class="kpi__valor">{{ $fmtPct($s->tasaExito()) }}</span>
                <span class="kpi__sub">{{ $s->ganados }} de {{ $s->total }} contrataron</span>
            </div>
            <div class="kpi">
                <span class="kpi__label">Tasa de cierre</span>
                <span class="kpi__valor">{{ $fmtPct($s->tasaCierre()) }}</span>
                <span class="kpi__sub">De los ya resueltos ({{ $s->ganados + $s->perdidos }})</span>
            </div>
            <div class="kpi">
                <span class="kpi__label">Primer contacto</span>
                <span class="kpi__valor">{{ $s->primerContactoTexto() ?? '—' }}</span>
                <span class="kpi__sub">Tiempo promedio de respuesta</span>
            </div>
        </div>

        <div class="row g-3">
            {{-- ===== Embudo ===== --}}
            <div class="col-12">
                <section class="mx-card h-100">
                    <div class="mx-card__title">Embudo de prospectos</div>

                    <ol class="embudo">
                        @foreach ($etapas as $i => $e)
                            @php $pct = LeadStats::pct($e['valor'], $s->total) ?? 0; @endphp
                            <li class="embudo__etapa">
                                <div class="embudo__cabeza">
                                    <span class="embudo__nombre">{{ $e['nombre'] }}</span>
                                    <span class="embudo__num"><strong>{{ number_format($e['valor']) }}</strong> · {{ $fmtPct($pct) }}</span>
                                </div>
                                <div class="embudo__pista">
                                    <span class="embudo__barra {{ $e['clase'] }}" style="width: {{ max($pct, $e['valor'] > 0 ? 2 : 0) }}%"
                                          tabindex="0" data-tip="{{ $e['nombre'] }}: {{ $e['valor'] }} ({{ $fmtPct($pct) }} de los recibidos). {{ $e['ayuda'] }}"></span>
                                </div>
                            </li>

                            @if ($i === 0)
                                <li class="embudo__fuga">
                                    <span class="embudo__fuga-titulo">No llegaron a contacto: <strong>{{ $fuga1 }}</strong></span>
                                    <span class="embudo__fuga-detalle">
                                        <span><span class="dot dot--pendiente"></span>{{ $s->sinContactar }} sin contactar todavía</span>
                                        <span><span class="dot dot--perdido"></span>{{ $s->perdidosSinContacto }} perdidos antes de contactar</span>
                                    </span>
                                </li>
                            @elseif ($i === 1)
                                <li class="embudo__fuga">
                                    <span class="embudo__fuga-titulo">Contactados que no han cerrado: <strong>{{ $fuga2 }}</strong></span>
                                    <span class="embudo__fuga-detalle">
                                        <span><span class="dot dot--pendiente"></span>{{ $s->enSeguimiento }} en seguimiento</span>
                                        <span><span class="dot dot--perdido"></span>{{ $s->perdidosTrasContacto }} perdidos después del contacto</span>
                                    </span>
                                </li>
                            @endif
                        @endforeach
                    </ol>

                    @if ($conclusion)
                        <p class="embudo__conclusion">{{ $conclusion }}</p>
                    @endif
                </section>
            </div>

            {{-- ===== Desgloses ===== --}}
            @foreach ($desgloses as $titulo => $filas)
                <div class="col-12 col-xl-6">
                    <section class="mx-card h-100">
                        <div class="mx-card__title">{{ $titulo }}</div>
                        <x-admin.tabla-tasa :filas="$filas" />
                    </section>
                </div>
            @endforeach

            {{-- ===== Asesores ===== --}}
            @if (count($s->porAsesor))
                <div class="col-12 col-xl-6">
                    <section class="mx-card h-100">
                        <div class="mx-card__title">Por asesor</div>
                        <div class="tabla-tasa-wrap"><table class="table tabla-tasa">
                            <thead>
                                <tr>
                                    <th scope="col">Asesor</th>
                                    <th scope="col" class="text-end">Atendidos</th>
                                    <th scope="col" class="text-end">Contactos</th>
                                    <th scope="col" class="text-end">Ganados</th>
                                    <th scope="col">Éxito</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($s->porAsesor as $a)
                                    @php $t = LeadStats::pct($a['ganados'], $a['atendidos']); @endphp
                                    <tr>
                                        <td data-label="Asesor" class="td-nombre fw-semibold">{{ $a['nombre'] }}</td>
                                        <td data-label="Atendidos" class="text-end num">{{ $a['atendidos'] }}</td>
                                        <td data-label="Contactos" class="text-end num">{{ $a['contactos'] }}</td>
                                        <td data-label="Ganados" class="text-end num">{{ $a['ganados'] }}</td>
                                        <td data-label="Éxito">
                                            <span class="medidor" tabindex="0" data-tip="{{ $a['nombre'] }}: {{ $a['ganados'] }} ganados de {{ $a['atendidos'] }} atendidos">
                                                <span class="medidor__pista"><span class="medidor__barra" style="width: {{ $t ?? 0 }}%"></span></span>
                                                <span class="medidor__num">{{ $fmtPct($t) }}</span>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table></div>
                        <p class="small text-secondary mb-0">"Atendidos": prospectos en los que registró al menos un contacto. "Ganados": los que él marcó como ganados.</p>
                    </section>
                </div>
            @endif
        </div>
    @endif

</x-admin.layout>
