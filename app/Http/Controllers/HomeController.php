<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'total'       => Report::count(),
            'resolved'    => Report::where('status', 'resolved')->count(),
            'in_progress' => Report::where('status', 'in_progress')->count(),
            'submitted'   => Report::where('status', 'submitted')->count(),
        ];

        return view('home', compact('stats'));
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
