<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Arrondissement;
use App\Models\Category;
use App\Models\Domain;
use App\Models\Report;
use App\Models\ReportStatusHistory;
use App\Models\Team;
use Illuminate\Http\Request;

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

        $reports         = $query->paginate(15)->appends($request->query());
        $domains         = Domain::orderBy('name')->get();
        $arrondissements = Arrondissement::orderBy('name')->get();

        return view('agent.reports.index', compact('reports', 'domains', 'arrondissements'));
    }

    public function show(Report $report)
    {
        $report->load(['domain', 'category', 'arrondissement', 'user', 'team', 'assignedBy', 'statusHistories.changedBy', 'photos']);

        // Filtrer les équipes par domaine du signalement
        $teams = Team::where('is_active', true)
            ->when($report->domain_id, fn($q) => $q->where('domain_id', $report->domain_id))
            ->orderBy('name')
            ->get();

        return view('agent.reports.show', compact('report', 'teams'));
    }

    public function updateStatus(Request $request, Report $report)
    {
        $validated = $request->validate([
            'status'   => 'required|in:submitted,validated,in_progress,resolved,archived',
            'priority' => 'required|in:low,medium,high,urgent',
            'comment'  => 'nullable|string|max:1000',
        ]);

        $oldStatus = $report->status;

        $report->update([
            'status'      => $validated['status'],
            'priority'    => $validated['priority'],
            'agent_notes' => $request->agent_notes,
            'resolved_at' => $validated['status'] === 'resolved' ? now() : $report->resolved_at,
        ]);

        if ($oldStatus !== $validated['status']) {
            ReportStatusHistory::create([
                'report_id'  => $report->id,
                'old_status' => $oldStatus,
                'new_status' => $validated['status'],
                'changed_by' => auth()->id(),
                'comment'    => $validated['comment'] ?? null,
            ]);
        }

        return redirect()->route('agent.reports.show', $report)
            ->with('success', 'Signalement mis à jour avec succès.');
    }

    public function assignTeam(Request $request, Report $report)
    {
        $validated = $request->validate([
            'assigned_team_id' => 'required|exists:teams,id',
        ]);

        $report->update([
            'assigned_team_id' => $validated['assigned_team_id'],
            'assigned_by'      => auth()->id(),
        ]);

        // Move to validated if still submitted
        if ($report->status === 'submitted') {
            $oldStatus = $report->status;
            $report->update(['status' => 'validated']);
            ReportStatusHistory::create([
                'report_id'  => $report->id,
                'old_status' => $oldStatus,
                'new_status' => 'validated',
                'changed_by' => auth()->id(),
                'comment'    => 'Équipe affectée : ' . Team::find($validated['assigned_team_id'])->name,
            ]);
        }

        return redirect()->route('agent.reports.show', $report)
            ->with('success', 'Équipe affectée avec succès.');
    }

    public function map()
    {
        $reports = Report::with(['category', 'arrondissement'])
            ->whereNotIn('status', ['archived'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        $categories      = Category::all();
        $arrondissements = Arrondissement::all();

        return view('agent.reports.map', compact('reports', 'categories', 'arrondissements'));
    }
}
