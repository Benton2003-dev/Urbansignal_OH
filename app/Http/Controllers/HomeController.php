<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'stats' => [
                'total'       => Report::count(),
                'resolved'    => Report::where('status', 'resolved')->count(),
                'in_progress' => Report::where('status', 'in_progress')->count(),
                'submitted'   => Report::where('status', 'submitted')->count(),
            ],
            'recentReports' => Report::with(['category', 'arrondissement'])
                                     ->whereNotIn('status', ['archived'])
                                     ->latest()
                                     ->take(6)
                                     ->get(),
        ]);
    }
    
    public function track(Request $request)
    {
        $report = null;
        if ($request->filled('ticket')) {
            $report = Report::with(['category', 'arrondissement', 'statusHistories.changedBy', 'photos'])
                ->where('ticket_number', strtoupper($request->ticket))
                ->first();
                }
                
                return view('track', compact('report'));
                }
                }