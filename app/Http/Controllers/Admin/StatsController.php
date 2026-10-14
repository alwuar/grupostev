<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\LeadFilters;
use App\Support\LeadStats;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** Tasa de éxito y embudo de prospectos */
class StatsController extends Controller
{
    public function index(Request $request): View
    {
        $filtros = LeadFilters::fromRequest($request);
        // Las estadísticas no usan búsqueda ni estado: siempre el embudo completo
        $filtros->buscar = null;
        $filtros->estado = null;
        $filtros->servicio = '';

        return view('admin.stats.index', [
            'filtros' => $filtros,
            'stats' => LeadStats::calcular($filtros),
        ]);
    }
}
