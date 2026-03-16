@extends('layouts.app')
@section('title', 'Signalements — Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tous les signalements</h1>
        <a href="{{ route('admin.reports.statistics') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Statistiques
        </a>
    </div>

    <form method="GET" class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Ticket ou titre..."
                   class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-purple-400 col-span-2 md:col-span-1">
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none">
                <option value="">Tous statuts</option>
                @foreach(['submitted'=>'Soumis','validated'=>'Validé','in_progress'=>'En cours','resolved'=>'Résolu','archived'=>'Archivé'] as $v=>$l)
                <option value="{{ $v }}" {{ request('status')===$v?'selected':'' }}>{{ $l }}</option>
                @endforeach
            </select>
            <select name="arrondissement_id" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none">
                <option value="">Tous arrondissements</option>
                @foreach($arrondissements as $arr)
                <option value="{{ $arr->id }}" {{ request('arrondissement_id')==$arr->id?'selected':'' }}>{{ $arr->name }}</option>
                @endforeach
            </select>
            <select name="category_id" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none">
                <option value="">Toutes catégories</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 px-3 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition">Filtrer</button>
                <a href="{{ route('admin.reports.index') }}" class="px-3 py-2 border border-gray-200 text-gray-600 text-sm rounded-lg hover:bg-gray-50">Reset</a>
            </div>
        </div>
    </form>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
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
                    @forelse($reports as $report)
                    @php
                    $sc=['submitted'=>'bg-gray-100 text-gray-700','validated'=>'bg-blue-100 text-blue-700','in_progress'=>'bg-yellow-100 text-yellow-800','resolved'=>'bg-green-100 text-green-800','archived'=>'bg-slate-100 text-slate-600'];
                    $pc=['low'=>'text-green-600','medium'=>'text-yellow-600','high'=>'text-orange-600','urgent'=>'text-red-600 font-bold'];
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3"><span class="font-mono text-xs bg-gray-100 px-2 py-0.5 rounded">{{ $report->ticket_number }}</span></td>
                        <td class="px-5 py-3 max-w-xs">
                            <p class="text-sm font-medium text-gray-900 line-clamp-1">{{ $report->title }}</p>
                            <p class="text-xs text-gray-400">{{ $report->category->name }}</p>
                        </td>
                        <td class="px-5 py-3 text-sm text-gray-600">{{ $report->user->name }}</td>
                        <td class="px-5 py-3 text-sm text-gray-500">{{ $report->arrondissement->name ?? '—' }}</td>
                        <td class="px-5 py-3 text-sm {{ $pc[$report->priority]??'' }}">{{ $report->priority_label }}</td>
                        <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $sc[$report->status]??'' }}">{{ $report->status_label }}</span></td>
                        <td class="px-5 py-3 text-xs text-gray-500">{{ $report->team->name ?? '—' }}</td>
                        <td class="px-5 py-3 text-xs text-gray-400">{{ $report->created_at->format('d/m/Y') }}</td>
                        <td class="px-5 py-3"><a href="{{ route('admin.reports.show', $report) }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">Voir →</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="py-12 text-center text-gray-400">Aucun signalement trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100">{{ $reports->links() }}</div>
    </div>
</div>
@endsection
