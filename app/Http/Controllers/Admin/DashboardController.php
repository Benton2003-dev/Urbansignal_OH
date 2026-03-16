<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_reports'   => Report::count(),
            'total_citizens'  => User::where('role', 'citizen')->count(),
            'total_agents'    => User::where('role', 'agent')->count(),
            'resolved'        => Report::where('status', 'resolved')->count(),
            'pending'         => Report::whereIn('status', ['submitted', 'validated', 'in_progress'])->count(),
            'this_month'      => Report::whereMonth('created_at', now()->month)->count(),
        ];

        // Reports per month (last 6 months)
        $monthly = Report::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Reports by status
        $byStatus = Report::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Reports by category
        $byCategory = Category::withCount('reports')
            ->orderByDesc('reports_count')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'monthly', 'byStatus', 'byCategory'));
    }
}
