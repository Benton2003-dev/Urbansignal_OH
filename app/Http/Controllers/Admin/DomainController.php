<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function index()
    {
        $domains = Domain::withCount(['categories', 'teams', 'reports'])->orderBy('name')->get();

        return view('admin.domains.index', compact('domains'));
    }

    public function create()
    {
        return view('admin.domains.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color'       => 'nullable|string|max:20',
        ]);

        Domain::create($validated);

        return redirect()->route('admin.domains.index')
            ->with('success', 'Domaine créé avec succès.');
    }

    public function edit(Domain $domain)
    {
        $domain->loadCount(['categories', 'teams', 'reports']);

        return view('admin.domains.edit', compact('domain'));
    }

    public function update(Request $request, Domain $domain)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color'       => 'nullable|string|max:20',
            'is_active'   => 'boolean',
        ]);

        $domain->update($validated);

        return redirect()->route('admin.domains.index')
            ->with('success', 'Domaine mis à jour.');
    }

    public function destroy(Domain $domain)
    {
        if ($domain->reports()->exists()) {
            return back()->with('error', 'Impossible de supprimer un domaine contenant des signalements.');
        }

        $domain->delete();

        return redirect()->route('admin.domains.index')
            ->with('success', 'Domaine supprimé.');
    }
}
