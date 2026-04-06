@extends('layouts.app')
@section('title', 'Signalements')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Signalements</h1>
        <a href="{{ route('agent.reports.map') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            Vue carte
        </a>
    </div>

    {{-- Filters --}}
    <form method="GET" class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Ticket ou titre..."
                   class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
            <select name="domain_id" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="">Tous domaines</option>
                @foreach($domains as $domain)
                <option value="{{ $domain->id }}" {{ request('domain_id') == $domain->id ? 'selected' : '' }}>{{ $domain->name }}</option>
                @endforeach
            </select>
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="">Tous les statuts</option>
                @foreach(['submitted'=>'Soumis','validated'=>'Validé','in_progress'=>'En cours','resolved'=>'Résolu','archived'=>'Archivé'] as $v => $l)
                <option value="{{ $v }}" {{ request('status') === $v ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
            </select>
            <select name="priority" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="">Toutes priorités</option>
                @foreach(['urgent'=>'Urgent','high'=>'Élevé','medium'=>'Moyen','low'=>'Faible'] as $v => $l)
                <option value="{{ $v }}" {{ request('priority') === $v ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
            </select>
            <select name="arrondissement_id" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="">Tous arrondissements</option>
                @foreach($arrondissements as $arr)
                <option value="{{ $arr->id }}" {{ request('arrondissement_id') == $arr->id ? 'selected' : '' }}>{{ $arr->name }}</option>
                @endforeach
            </select>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 px-3 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800 transition">Filtrer</button>
                <a href="{{ route('agent.reports.index') }}" class="px-3 py-2 border border-gray-200 text-gray-600 text-sm rounded-lg hover:bg-gray-50 transition">Réinitialiser</a>
            </div>
        </div>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($reports->isEmpty())
        <div class="py-16 text-center text-gray-400">
            <p>Aucun signalement trouvé.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Ticket</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Problème</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Citoyen</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Localisation</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Priorité</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Équipe</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($reports as $report)
                    @php
                    $sc = ['submitted'=>'bg-gray-100 text-gray-700','validated'=>'bg-blue-100 text-blue-700','in_progress'=>'bg-yellow-100 text-yellow-800','resolved'=>'bg-green-100 text-blue-800','archived'=>'bg-slate-100 text-slate-600'];
                    $pc = ['low'=>'text-blue-600','medium'=>'text-yellow-600','high'=>'text-orange-600','urgent'=>'text-red-600 font-bold'];
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3 whitespace-nowrap">
                            <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">{{ $report->ticket_number }}</span>
                        </td>
                        <td class="px-5 py-3 max-w-xs">
                            <p class="text-sm font-medium text-gray-900 line-clamp-1">{{ $report->title }}</p>
                            <p class="text-xs text-gray-400">{{ $report->category->name }}</p>
                        </td>
                        <td class="px-5 py-3 text-sm text-gray-600">{{ $report->user->name }}</td>
                        <td class="px-5 py-3 text-sm text-gray-500">{{ $report->arrondissement->name ?? '—' }}</td>
                        <td class="px-5 py-3 text-sm whitespace-nowrap {{ $pc[$report->priority] ?? '' }}">{{ $report->priority_label }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium whitespace-nowrap {{ $sc[$report->status] ?? '' }}">{{ $report->status_label }}</span>
                        </td>
                        <td class="px-5 py-3 text-xs text-gray-500">{{ $report->team->name ?? '—' }}</td>
                        <td class="px-5 py-3 text-xs text-gray-400">{{ $report->created_at->format('d/m/Y') }}</td>
                        <td class="px-5 py-3">
                            <a href="{{ route('agent.reports.show', $report) }}" title="Gérer ce signalement" class="p-1.5 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition inline-flex">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $reports->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
