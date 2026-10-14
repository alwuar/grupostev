<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ActivityType;
use App\Enums\LeadStatus;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Service;
use App\Support\LeadFilters;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $filtros = LeadFilters::fromRequest($request);

        $leads = $filtros->query()
            ->with(['latestActivity', 'service'])
            ->latest()
            ->latest('id')
            ->paginate(25)
            ->withQueryString();

        // Conteo por estado dentro del periodo/búsqueda actual
        $conteos = $filtros->applyBase(Lead::query())
            ->selectRaw('estado, count(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado');

        return view('admin.leads.index', [
            'leads' => $leads,
            'filtros' => $filtros,
            'conteos' => $conteos,
            'totalPeriodo' => $conteos->sum(),
            'servicios' => Service::orderBy('orden')->orderBy('id')->get(),
        ]);
    }

    public function show(Lead $lead): View
    {
        $lead->load(['activities.user', 'service']);

        return view('admin.leads.show', [
            'lead' => $lead,
            'estados' => LeadStatus::cases(),
            'servicios' => Service::orderByDesc('activo')->orderBy('orden')->orderBy('id')->get(),
        ]);
    }

    /** Cambia el servicio que le interesa */
    public function updateInteres(Request $request, Lead $lead): RedirectResponse
    {
        $datos = $request->validate([
            'service_id' => ['nullable', Rule::exists('services', 'id')],
        ], [], ['service_id' => 'servicio']);

        $nuevo = isset($datos['service_id']) ? Service::find($datos['service_id']) : null;

        if ($nuevo?->id === $lead->service_id) {
            return back();
        }

        DB::transaction(function () use ($lead, $nuevo, $request) {
            $antes = $lead->service?->nombre ?? 'Sin definir';

            $lead->update(['service_id' => $nuevo?->id]);

            $lead->activities()->create([
                'user_id' => $request->user()->id,
                'tipo' => ActivityType::Interes,
                'estado' => $lead->estado,
                'asunto' => 'Interés actualizado',
                'nota' => $antes.' → '.($nuevo?->nombre ?? 'Sin definir'),
            ]);
        });

        return redirect()->route('admin.leads.show', $lead)->with('status', 'Interés actualizado.');
    }

    /** Exporta a CSV (abre directo en Excel) con los mismos filtros de la tabla */
    public function export(Request $request): StreamedResponse
    {
        $filtros = LeadFilters::fromRequest($request);

        $nombre = 'prospectos-grupo-stev-'.$filtros->periodo
            .($filtros->estado ? '-'.$filtros->estado->value : '')
            .'-'.now()->format('Y-m-d').'.csv';

        $query = $filtros->query()
            ->with(['latestActivity.user', 'service'])
            ->latest()
            ->latest('id');

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // BOM para que Excel respete acentos

            fputcsv($out, [
                'Folio', 'Fecha de registro', 'Nombre', 'Teléfono', 'Correo', 'Empresa', 'Ciudad',
                'Servicio de interés', 'Origen', 'Estado',
                'Último contacto', 'Último asunto', 'Última nota', 'Último registro por',
            ]);

            $query->chunk(500, function ($leads) use ($out) {
                foreach ($leads as $lead) {
                    $ultima = $lead->latestActivity;

                    fputcsv($out, [
                        $lead->folio(),
                        $lead->created_at->format('Y-m-d H:i'),
                        $lead->nombre,
                        $lead->telefono,
                        $lead->email,
                        $lead->empresa,
                        $lead->ciudad,
                        $lead->interesLabel() ?? 'Sin definir',
                        $lead->origenLabel(),
                        $lead->estado->label(),
                        $lead->ultimo_contacto_at?->format('Y-m-d H:i'),
                        $ultima?->asunto,
                        $ultima?->nota,
                        $ultima?->autor(),
                    ]);
                }
            });

            fclose($out);
        }, $nombre, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
