<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with('domain')->withCount('reports')->orderBy('name')->get();

        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        $domains = Domain::where('is_active', true)->orderBy('name')->get();

        return view('admin.teams.create', compact('domains'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'domain_id'     => 'required|exists:domains,id',
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string|max:500',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
        ]);

        Team::create($validated);

        return redirect()->route('admin.teams.index')
            ->with('success', 'Équipe créée avec succès.');
    }

    public function edit(Team $team)
    {
        $domains = Domain::where('is_active', true)->orderBy('name')->get();

        return view('admin.teams.edit', compact('team', 'domains'));
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'domain_id'     => 'required|exists:domains,id',
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string|max:500',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'is_active'     => 'boolean',
        ]);

        $team->update($validated);

        return redirect()->route('admin.teams.index')
            ->with('success', 'Équipe mise à jour.');
    }

    public function destroy(Team $team)
    {
        if ($team->reports()->exists()) {
            return back()->with('error', 'Impossible de supprimer une équipe ayant des signalements assignés.');
        }

        $team->delete();

        return redirect()->route('admin.teams.index')
            ->with('success', 'Équipe supprimée.');
    }
}
