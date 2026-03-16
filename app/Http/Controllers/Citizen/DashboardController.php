<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user    = auth()->user();
        $reports = Report::with(['category', 'arrondissement'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        $stats = [
            'total'       => Report::where('user_id', $user->id)->count(),
            'submitted'   => Report::where('user_id', $user->id)->where('status', 'submitted')->count(),
            'in_progress' => Report::where('user_id', $user->id)->whereIn('status', ['validated', 'in_progress'])->count(),
            'resolved'    => Report::where('user_id', $user->id)->where('status', 'resolved')->count(),
        ];

        return view('citizen.dashboard', compact('reports', 'stats'));
    }
}
