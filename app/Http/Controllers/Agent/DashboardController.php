<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Arrondissement;
use App\Models\Category;
use App\Models\Report;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'submitted'   => Report::where('status', 'submitted')->count(),
            'validated'   => Report::where('status', 'validated')->count(),
            'in_progress' => Report::where('status', 'in_progress')->count(),
            'resolved'    => Report::where('status', 'resolved')->count(),
            'total'       => Report::count(),
            'urgent'      => Report::where('priority', 'urgent')->whereNotIn('status', ['resolved', 'archived'])->count(),
        ];

        $recentReports = Report::with(['category', 'arrondissement', 'user'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $arrondissements = Arrondissement::withCount('reports')->get();
        $categories      = Category::withCount('reports')->get();

        // Reports for map (all non-archived with GPS)
        $mapReports = Report::with(['category', 'arrondissement'])
            ->whereNotIn('status', ['archived'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'ticket_number', 'title', 'status', 'priority', 'latitude', 'longitude', 'category_id', 'arrondissement_id', 'created_at']);

        return view('agent.dashboard', compact('stats', 'recentReports', 'arrondissements', 'categories', 'mapReports'));
    }
}
