{{-- Tabla de desglose: prospectos, ganados, perdidos y tasa de éxito con medidor --}}
@props(['filas' => []])

@php
    use App\Support\LeadStats;
    $fmtPct = fn (?float $v) => $v === null ? '—' : rtrim(rtrim(number_format($v, 1), '0'), '.').'%';
@endphp

@if (empty($filas))
    <p class="text-secondary mb-0">Sin datos en este periodo.</p>
@else
    <div class="tabla-tasa-wrap"><table class="table tabla-tasa">
        <thead>
            <tr>
                <th scope="col"><span class="visually-hidden">Grupo</span></th>
                <th scope="col" class="text-end">Prospectos</th>
                <th scope="col" class="text-end">Ganados</th>
                <th scope="col" class="text-end">Perdidos</th>
                <th scope="col">Éxito</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($filas as $f)
                @php $t = LeadStats::pct($f['ganados'], $f['total']); @endphp
                <tr>
                    <td data-label="" class="td-nombre fw-semibold">{{ $f['nombre'] }}</td>
                    <td data-label="Prospectos" class="text-end num">{{ $f['total'] }}</td>
                    <td data-label="Ganados" class="text-end num">{{ $f['ganados'] }}</td>
                    <td data-label="Perdidos" class="text-end num">{{ $f['perdidos'] }}</td>
                    <td data-label="Éxito">
                        <span class="medidor" tabindex="0" data-tip="{{ $f['nombre'] }}: {{ $f['ganados'] }} ganados de {{ $f['total'] }} prospectos">
                            <span class="medidor__pista"><span class="medidor__barra" style="width: {{ $t ?? 0 }}%"></span></span>
                            <span class="medidor__num">{{ $fmtPct($t) }}</span>
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table></div>
@endif
