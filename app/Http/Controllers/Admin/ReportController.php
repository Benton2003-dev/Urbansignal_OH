<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Arrondissement;
use App\Models\Category;
use App\Models\Domain;
use App\Models\Report;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with(['domain', 'category', 'arrondissement', 'user', 'team'])
            ->orderByDesc('created_at');

        if ($request->filled('domain_id')) {
            $query->where('domain_id', $request->domain_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('arrondissement_id')) {
            $query->where('arrondissement_id', $request->arrondissement_id);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%$search%")
                  ->orWhere('title', 'like', "%$search%");
            });
        }

        $reports         = $query->paginate(20)->appends($request->query());
        $domains         = Domain::orderBy('name')->get();
        $arrondissements = Arrondissement::orderBy('name')->get();

        return view('admin.reports.index', compact('reports', 'domains', 'arrondissements'));
    }

    public function show(Report $report)
    {
        $report->load(['domain', 'category', 'arrondissement', 'user', 'team', 'assignedBy', 'statusHistories.changedBy', 'photos']);

        $teams = Team::where('is_active', true)
            ->when($report->domain_id, fn($q) => $q->where('domain_id', $report->domain_id))
            ->orderBy('name')
            ->get();

        return view('admin.reports.show', compact('report', 'teams'));
    }

    public function statistics()
    {
        $byStatus = Report::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $byPriority = Report::select('priority', DB::raw('COUNT(*) as total'))
            ->groupBy('priority')
            ->pluck('total', 'priority');

        $byArrondissement = Arrondissement::withCount('reports')
            ->orderByDesc('reports_count')
            ->get();

        $byCategory = Category::withCount('reports')
            ->orderByDesc('reports_count')
            ->get();

        // Données réelles groupées par mois
        $rawMonthly = Report::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as period'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('period')
            ->pluck('total', 'period');

        // Générer les 12 derniers mois complets (avec 0 si aucune donnée)
        $monthly = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date   = now()->subMonths($i);
            $period = $date->format('Y-m');
            $monthly->push([
                'period' => $period,
                'month'  => (int) $date->format('m'),
                'year'   => (int) $date->format('Y'),
                'label'  => ucfirst($date->locale('fr')->isoFormat('MMM')),
                'total'  => $rawMonthly[$period] ?? 0,
            ]);
        }

        return view('admin.reports.statistics', compact('byStatus', 'byPriority', 'byArrondissement', 'byCategory', 'monthly'));
    }
}
