@extends('layouts.app')
@section('title', 'Tableau de bord Agent')

@push('styles')
<style>#dashboard-map { height: 400px; border-radius: 12px; }</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tableau de bord Agent</h1>
            <p class="text-gray-500 text-sm mt-1">Bonjour, {{ auth()->user()->name }} — Secrétariat exécutif</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('agent.reports.map') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                Carte complète
            </a>
            <a href="{{ route('agent.reports.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition text-sm">
                Tous les signalements
            </a>
        </div>
    </div>

    {{-- KPIs --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        @php
        $kpis = [
            ['label'=>'Total', 'value'=>$stats['total'], 'bg'=>'bg-gray-50', 'text'=>'text-gray-800'],
            ['label'=>'Soumis', 'value'=>$stats['submitted'], 'bg'=>'bg-gray-50', 'text'=>'text-gray-600'],
            ['label'=>'Validés', 'value'=>$stats['validated'], 'bg'=>'bg-blue-50', 'text'=>'text-blue-700'],
            ['label'=>'En cours', 'value'=>$stats['in_progress'], 'bg'=>'bg-yellow-50', 'text'=>'text-yellow-700'],
            ['label'=>'Résolus', 'value'=>$stats['resolved'], 'bg'=>'bg-green-50', 'text'=>'text-green-700'],
            ['label'=>'Urgents', 'value'=>$stats['urgent'], 'bg'=>'bg-red-50', 'text'=>'text-red-700'],
        ];
        @endphp
        @foreach($kpis as $kpi)
        <div class="{{ $kpi['bg'] }} rounded-xl p-4 border border-gray-100">
            <div class="text-2xl font-bold {{ $kpi['text'] }}">{{ $kpi['value'] }}</div>
            <div class="text-xs text-gray-500 mt-1">{{ $kpi['label'] }}</div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Map --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-semibold text-gray-900">Carte des signalements</h2>
                    <a href="{{ route('agent.reports.map') }}" class="text-sm text-blue-600 hover:underline">Plein écran →</a>
                </div>
                <div id="dashboard-map"></div>
                <div class="flex flex-wrap gap-4 mt-3 text-xs text-gray-500">
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span> Urgent</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-orange-500 inline-block"></span> Élevé</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-yellow-400 inline-block"></span> Moyen</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span> Faible</span>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            {{-- Stats par arrondissement --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-semibold text-gray-900 mb-4">Par arrondissement</h2>
                <div class="space-y-2">
                    @foreach($arrondissements->sortByDesc('reports_count')->take(6) as $arr)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 truncate">{{ $arr->name }}</span>
                        <div class="flex items-center gap-2">
                            <div class="h-1.5 bg-green-200 rounded-full" style="width: {{ $arr->reports_count > 0 ? min($arr->reports_count * 10, 80) : 0 }}px"></div>
                            <span class="text-sm font-semibold text-gray-800 w-6 text-right">{{ $arr->reports_count }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Stats par catégorie --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-semibold text-gray-900 mb-4">Par catégorie</h2>
                <div class="space-y-2">
                    @foreach($categories->sortByDesc('reports_count')->take(5) as $cat)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 truncate">{{ $cat->name }}</span>
                        <span class="text-sm font-semibold text-gray-800">{{ $cat->reports_count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Recent reports --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mt-6 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900">Signalements récents</h2>
            <a href="{{ route('agent.reports.index') }}" class="text-sm text-green-600 hover:underline">Voir tous →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Ticket</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Problème</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Citoyen</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Arrondissement</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Priorité</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($recentReports as $report)
                    @php
                    $statusColors = ['submitted'=>'bg-gray-100 text-gray-700','validated'=>'bg-blue-100 text-blue-700','in_progress'=>'bg-yellow-100 text-yellow-800','resolved'=>'bg-green-100 text-green-800','archived'=>'bg-slate-100 text-slate-600'];
                    $priorityColors = ['low'=>'text-green-600','medium'=>'text-yellow-600','high'=>'text-orange-600','urgent'=>'text-red-600 font-bold'];
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-3">
                            <span class="font-mono text-xs font-medium text-gray-600 bg-gray-100 px-2 py-1 rounded">{{ $report->ticket_number }}</span>
                        </td>
                        <td class="px-6 py-3">
                            <div class="text-sm font-medium text-gray-900 line-clamp-1 max-w-xs">{{ $report->title }}</div>
                            <div class="text-xs text-gray-400">{{ $report->category->name }}</div>
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-600">{{ $report->user->name }}</td>
                        <td class="px-6 py-3 text-sm text-gray-500">{{ $report->arrondissement->name ?? '—' }}</td>
                        <td class="px-6 py-3 text-sm {{ $priorityColors[$report->priority] ?? '' }}">{{ $report->priority_label }}</td>
                        <td class="px-6 py-3">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$report->status] ?? '' }}">{{ $report->status_label }}</span>
                        </td>
                        <td class="px-6 py-3 text-right">
                            <a href="{{ route('agent.reports.show', $report) }}" title="Gérer ce signalement" class="p-1.5 rounded-lg text-gray-400 hover:text-green-600 hover:bg-green-50 transition inline-flex">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
window.addEventListener('load', function () {
    const map = L.map('dashboard-map').setView([6.3622, 2.0852], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap', maxZoom: 19
    }).addTo(map);

    // Force recalcul taille après rendu complet
    setTimeout(() => map.invalidateSize(), 200);

    const clusters = L.markerClusterGroup();
    const priorityColors = { urgent: '#EF4444', high: '#F97316', medium: '#EAB308', low: '#22C55E' };

    const reports = @json($mapReports);
    reports.forEach(r => {
        if (!r.latitude || !r.longitude) return;
        const color = priorityColors[r.priority] || '#6B7280';
        const icon = L.divIcon({
            className: '',
            html: `<div style="background:${color};width:12px;height:12px;border-radius:50%;border:2px solid white;box-shadow:0 1px 4px rgba(0,0,0,0.4)"></div>`,
            iconSize: [12, 12], iconAnchor: [6, 6]
        });
        const m = L.marker([r.latitude, r.longitude], { icon })
            .bindPopup(`<strong>${r.ticket_number}</strong><br>${r.title}<br><small>${r.status}</small>`)
            .on('click', () => window.location.href = '/agent/signalements/' + r.id);
        clusters.addLayer(m);
    });
    map.addLayer(clusters);
});
</script>
@endpush
