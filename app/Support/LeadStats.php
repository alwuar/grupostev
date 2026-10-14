<?php

namespace App\Support;

use App\Enums\ActivityType;
use App\Enums\LeadStatus;
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Calcula las estadísticas del embudo a partir de los prospectos filtrados.
 *
 * Embudo: Recibido → Contactado → Ganado.
 * "Dónde se pierde" se obtiene del historial: el estado que tenía el prospecto
 * justo antes de marcarlo como Perdido.
 */
class LeadStats
{
    public int $total = 0;

    public int $ganados = 0;

    public int $perdidos = 0;

    public int $sinContactar = 0;   // siguen en Recibido

    public int $enSeguimiento = 0;  // siguen en Contactado

    public int $contactados = 0;    // llegaron al menos a Contactado

    public int $perdidosSinContacto = 0;

    public int $perdidosTrasContacto = 0;

    public ?float $horasPrimerContacto = null; // promedio

    /** @var array<int, array{nombre: string, total: int, ganados: int, perdidos: int}> */
    public array $porOrigen = [];

    public array $porInteres = [];

    public array $porAsesor = [];

    public static function calcular(LeadFilters $filtros): self
    {
        $s = new self;

        /** @var Collection<int, Lead> $leads */
        $leads = $filtros->applyBase(Lead::query())
            ->with(['activities' => fn ($q) => $q->select('id', 'lead_id', 'user_id', 'tipo', 'estado', 'estado_anterior', 'created_at')->oldest()->oldest('id'),
                'service'])
            ->get();

        $s->total = $leads->count();

        $tiemposPrimerContacto = [];
        $asesores = [];

        foreach ($leads as $lead) {
            $contactos = $lead->activities->filter(fn (LeadActivity $a) => $a->tipo === ActivityType::Contacto && $a->user_id);

            // Tiempo al primer contacto registrado por una persona
            if ($primero = $contactos->first()) {
                $tiemposPrimerContacto[] = max(0, $lead->created_at->diffInMinutes($primero->created_at)) / 60;
            }

            // Quién atendió y quién cerró
            foreach ($contactos->pluck('user_id')->unique() as $uid) {
                $asesores[$uid]['atendidos'] = ($asesores[$uid]['atendidos'] ?? 0) + 1;
            }
            foreach ($contactos as $c) {
                $asesores[$c->user_id]['contactos'] = ($asesores[$c->user_id]['contactos'] ?? 0) + 1;
            }

            switch ($lead->estado) {
                case LeadStatus::Recibido:
                    $s->sinContactar++;
                    break;

                case LeadStatus::Contactado:
                    $s->enSeguimiento++;
                    $s->contactados++;
                    break;

                case LeadStatus::Ganado:
                    $s->ganados++;
                    $s->contactados++;
                    // Solo cuenta el contacto que lo marcó como ganado (no cambios de interés)
                    $cierre = $contactos->last(fn ($a) => $a->estado === LeadStatus::Ganado && $a->estado_anterior !== LeadStatus::Ganado);
                    if ($cierre?->user_id) {
                        $asesores[$cierre->user_id]['ganados'] = ($asesores[$cierre->user_id]['ganados'] ?? 0) + 1;
                    }
                    break;

                case LeadStatus::Perdido:
                    $s->perdidos++;
                    $baja = $contactos->last(fn ($a) => $a->estado === LeadStatus::Perdido && $a->estado_anterior !== LeadStatus::Perdido);
                    if ($baja && $baja->estado_anterior && $baja->estado_anterior !== LeadStatus::Recibido) {
                        $s->perdidosTrasContacto++;
                        $s->contactados++;
                    } else {
                        $s->perdidosSinContacto++;
                    }
                    break;
            }
        }

        $s->horasPrimerContacto = $tiemposPrimerContacto ? array_sum($tiemposPrimerContacto) / count($tiemposPrimerContacto) : null;

        // ===== Desgloses =====
        $s->porOrigen = self::agrupar($leads, fn (Lead $l) => $l->origen, Lead::ORIGENES);

        $s->porInteres = self::agrupar($leads, fn (Lead $l) => $l->service_id ?? 0,
            Service::orderBy('orden')->orderBy('id')->pluck('nombre', 'id')->all() + [0 => 'Sin definir']);

        $nombres = User::whereIn('id', array_keys($asesores))->pluck('name', 'id');
        $s->porAsesor = collect($asesores)
            ->map(fn ($a, $uid) => [
                'nombre' => $nombres[$uid] ?? 'Usuario eliminado',
                'atendidos' => $a['atendidos'] ?? 0,
                'contactos' => $a['contactos'] ?? 0,
                'ganados' => $a['ganados'] ?? 0,
            ])
            ->sortByDesc(fn ($a) => [$a['ganados'], $a['atendidos']])
            ->values()
            ->all();

        return $s;
    }

    /**
     * Cuenta total/ganados/perdidos por una llave, en el orden de $nombres.
     * Las filas sin prospectos no se muestran.
     */
    private static function agrupar(Collection $leads, callable $llave, array $nombres): array
    {
        $grupos = $leads->groupBy($llave);
        $filas = [];

        foreach ($nombres as $id => $nombre) {
            $g = $grupos->get($id);
            if (! $g || $g->isEmpty()) {
                continue;
            }
            $filas[] = [
                'nombre' => $nombre,
                'total' => $g->count(),
                'ganados' => $g->where('estado', LeadStatus::Ganado)->count(),
                'perdidos' => $g->where('estado', LeadStatus::Perdido)->count(),
            ];
        }

        // Llaves que no están en el catálogo (p. ej. un origen nuevo)
        foreach ($grupos as $id => $g) {
            if (! array_key_exists($id, $nombres)) {
                $filas[] = [
                    'nombre' => (string) $id,
                    'total' => $g->count(),
                    'ganados' => $g->where('estado', LeadStatus::Ganado)->count(),
                    'perdidos' => $g->where('estado', LeadStatus::Perdido)->count(),
                ];
            }
        }

        return $filas;
    }

    /** % con un decimal; null si no hay base */
    public static function pct(int|float $parte, int|float $base): ?float
    {
        return $base > 0 ? round($parte * 100 / $base, 1) : null;
    }

    public function tasaExito(): ?float
    {
        return self::pct($this->ganados, $this->total);
    }

    /** De los que ya se resolvieron (ganados + perdidos), cuántos se ganaron */
    public function tasaCierre(): ?float
    {
        return self::pct($this->ganados, $this->ganados + $this->perdidos);
    }

    /** Tiempo promedio al primer contacto en texto: "35 min", "5.2 h", "1.8 días" */
    public function primerContactoTexto(): ?string
    {
        $h = $this->horasPrimerContacto;

        return match (true) {
            $h === null => null,
            $h < 1 => round($h * 60).' min',
            $h < 48 => rtrim(rtrim(number_format($h, 1), '0'), '.').' h',
            default => rtrim(rtrim(number_format($h / 24, 1), '0'), '.').' días',
        };
    }
}
