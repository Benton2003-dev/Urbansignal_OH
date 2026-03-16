@extends('layouts.app')
@section('title', 'Statistiques — Admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Statistiques</h1>
            <p class="text-gray-500 text-sm mt-1">Données mises à jour en temps réel</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 transition">← Retour</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        {{-- By status --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-semibold text-gray-900 mb-5">Par statut</h2>
            @php
            $statusLabels = ['submitted'=>'Soumis','validated'=>'Validé','in_progress'=>'En cours','resolved'=>'Résolu','archived'=>'Archivé'];
            $statusColors = ['submitted'=>'#6B7280','validated'=>'#3B82F6','in_progress'=>'#EAB308','resolved'=>'#22C55E','archived'=>'#94A3B8'];
            $total = $byStatus->sum();
            @endphp
            <div class="space-y-4">
                @foreach($statusLabels as $key => $label)
                @php $count = $byStatus[$key] ?? 0; $pct = $total > 0 ? round($count / $total * 100) : 0; @endphp
                <div>
                    <div class="flex justify-between text-sm mb-1.5">
                        <span class="text-gray-700">{{ $label }}</span>
                        <span class="font-bold text-gray-900">{{ $count }} <span class="font-normal text-gray-400">({{ $pct }}%)</span></span>
                    </div>
                    <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full" style="width: {{ $pct }}%; background-color: {{ $statusColors[$key] ?? '#6B7280' }}"></div>
                    </div>
                </div>
                @endforeach
                <p class="text-xs text-gray-400 pt-2 border-t border-gray-100">Total : <strong>{{ $total }}</strong> signalements</p>
            </div>
        </div>

        {{-- By priority --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-semibold text-gray-900 mb-5">Par priorité</h2>
            @php
            $priorityLabels = ['urgent'=>'Urgent','high'=>'Élevé','medium'=>'Moyen','low'=>'Faible'];
            $priorityColors = ['urgent'=>'#EF4444','high'=>'#F97316','medium'=>'#EAB308','low'=>'#22C55E'];
            $totalP = $byPriority->sum();
            @endphp
            <div class="space-y-4">
                @foreach($priorityLabels as $key => $label)
                @php $count = $byPriority[$key] ?? 0; $pct = $totalP > 0 ? round($count / $totalP * 100) : 0; @endphp
                <div>
                    <div class="flex justify-between text-sm mb-1.5">
                        <span class="text-gray-700">{{ $label }}</span>
                        <span class="font-bold text-gray-900">{{ $count }} <span class="font-normal text-gray-400">({{ $pct }}%)</span></span>
                    </div>
                    <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full" style="width: {{ $pct }}%; background-color: {{ $priorityColors[$key] ?? '#6B7280' }}"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- By arrondissement --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-semibold text-gray-900 mb-5">Par arrondissement</h2>
            @php $maxArr = $byArrondissement->max('reports_count') ?: 1; @endphp
            <div class="space-y-3">
                @foreach($byArrondissement->sortByDesc('reports_count') as $arr)
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-600 w-36 truncate">{{ $arr->name }}</span>
                    <div class="flex-1 h-2.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 rounded-full" style="width: {{ round($arr->reports_count / $maxArr * 100) }}%"></div>
                    </div>
                    <span class="text-sm font-semibold text-gray-800 w-6 text-right">{{ $arr->reports_count }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- By category --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-semibold text-gray-900 mb-5">Par catégorie</h2>
            @php $maxCat = $byCategory->max('reports_count') ?: 1; @endphp
            <div class="space-y-3">
                @foreach($byCategory->sortByDesc('reports_count') as $cat)
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $cat->color }}"></div>
                    <span class="text-sm text-gray-600 flex-1 truncate">{{ $cat->name }}</span>
                    <div class="w-32 h-2.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full" style="width: {{ round($cat->reports_count / $maxCat * 100) }}%; background-color: {{ $cat->color }}"></div>
                    </div>
                    <span class="text-sm font-semibold text-gray-800 w-6 text-right">{{ $cat->reports_count }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Monthly trend --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="font-semibold text-gray-900 mb-1">Tendance mensuelle (12 derniers mois)</h2>
        <p class="text-xs text-gray-400 mb-6">Nombre de signalements soumis par mois</p>
        @php
            $maxMonthly = $monthly->max('total') ?: 1;
            $maxBarPx   = 120; // hauteur max en pixels
        @endphp
        <div class="flex items-end gap-2" style="height: 160px; padding-bottom: 28px; position: relative;">
            @foreach($monthly as $m)
            @php
                $barPx          = $m['total'] > 0 ? max(round($m['total'] / $maxMonthly * $maxBarPx), 8) : 4;
                $isCurrentMonth = $m['period'] === now()->format('Y-m');
                $barClass       = $isCurrentMonth ? 'bg-green-500 hover:bg-green-600' : ($m['total'] > 0 ? 'bg-green-300 hover:bg-green-400' : 'bg-gray-100');
            @endphp
            <div class="flex-1 flex flex-col items-center group" style="height: 100%; justify-content: flex-end; position: relative;">
                {{-- Valeur au survol --}}
                <span class="absolute text-xs font-semibold text-gray-700 opacity-0 group-hover:opacity-100 transition-opacity"
                      style="bottom: {{ $barPx + 30 }}px; left: 50%; transform: translateX(-50%); white-space: nowrap;">
                    {{ $m['total'] }}
                </span>
                {{-- Barre --}}
                <div class="w-full rounded-t-md transition-colors cursor-default {{ $barClass }}"
                     style="height: {{ $barPx }}px;"
                     title="{{ $m['label'] }} {{ $m['year'] }} : {{ $m['total'] }} signalement(s)">
                </div>
                {{-- Label mois --}}
                <span class="text-xs mt-1.5 absolute" style="bottom: 0; left: 50%; transform: translateX(-50%); {{ $isCurrentMonth ? 'color:#16a34a;font-weight:700' : 'color:#9ca3af' }}">
                    {{ $m['label'] }}
                </span>
            </div>
            @endforeach
        </div>
        <div class="mt-2 pt-3 border-t border-gray-100 flex items-center gap-4 text-xs text-gray-400">
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-green-500 inline-block"></span> Mois en cours</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-green-300 inline-block"></span> Mois avec données</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-gray-100 border border-gray-200 inline-block"></span> Aucun signalement</span>
        </div>
    </div>
</div>
@endsection
