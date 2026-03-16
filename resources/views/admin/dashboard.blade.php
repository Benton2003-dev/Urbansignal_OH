@extends('layouts.app')
@section('title', 'Tableau de bord Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tableau de bord</h1>
            <p class="text-gray-500 text-sm mt-1">Vue d'ensemble — UrbanSignal Ouidah</p>
        </div>
        <a href="{{ route('admin.reports.statistics') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Statistiques détaillées
        </a>
    </div>

    {{-- KPI cards --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        @php
        $kpis = [
            ['label'=>'Total signalements', 'value'=>$stats['total_reports'], 'bg'=>'bg-white', 'color'=>'text-gray-500',
             'icon'=>'<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>'],
            ['label'=>'Citoyens', 'value'=>$stats['total_citizens'], 'bg'=>'bg-white', 'color'=>'text-blue-500',
             'icon'=>'<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'],
            ['label'=>'Agents', 'value'=>$stats['total_agents'], 'bg'=>'bg-white', 'color'=>'text-purple-500',
             'icon'=>'<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'],
            ['label'=>'Résolus', 'value'=>$stats['resolved'], 'bg'=>'bg-green-50', 'color'=>'text-green-500',
             'icon'=>'<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'],
            ['label'=>'En attente', 'value'=>$stats['pending'], 'bg'=>'bg-yellow-50', 'color'=>'text-yellow-500',
             'icon'=>'<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'],
            ['label'=>'Ce mois-ci', 'value'=>$stats['this_month'], 'bg'=>'bg-blue-50', 'color'=>'text-blue-500',
             'icon'=>'<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'],
        ];
        @endphp
        @foreach($kpis as $kpi)
        <div class="{{ $kpi['bg'] }} rounded-xl p-4 shadow-sm border border-gray-100 text-center">
            <div class="w-8 h-8 mx-auto mb-1 {{ $kpi['color'] }}">{!! $kpi['icon'] !!}</div>
            <div class="text-2xl font-bold text-gray-900">{{ $kpi['value'] }}</div>
            <div class="text-xs text-gray-500 mt-1 leading-tight">{{ $kpi['label'] }}</div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        {{-- Status distribution --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-semibold text-gray-900 mb-4">Répartition par statut</h2>
            @php
            $statusLabels = ['submitted'=>'Soumis','validated'=>'Validé','in_progress'=>'En cours','resolved'=>'Résolu','archived'=>'Archivé'];
            $statusColors = ['submitted'=>'bg-gray-400','validated'=>'bg-blue-500','in_progress'=>'bg-yellow-500','resolved'=>'bg-green-500','archived'=>'bg-slate-400'];
            $total = $byStatus->sum();
            @endphp
            <div class="space-y-3">
                @foreach($statusLabels as $key => $label)
                @php $count = $byStatus[$key] ?? 0; $pct = $total > 0 ? round($count / $total * 100) : 0; @endphp
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">{{ $label }}</span>
                        <span class="font-semibold text-gray-800">{{ $count }} <span class="text-gray-400 font-normal text-xs">({{ $pct }}%)</span></span>
                    </div>
                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="{{ $statusColors[$key] ?? 'bg-gray-300' }} h-full rounded-full transition-all" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Top categories --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-semibold text-gray-900 mb-4">Top catégories</h2>
            <div class="space-y-3">
                @php $maxCat = $byCategory->max('reports_count') ?: 1; @endphp
                @foreach($byCategory as $cat)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600 truncate">{{ $cat->name }}</span>
                        <span class="font-semibold text-gray-800">{{ $cat->reports_count }}</span>
                    </div>
                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all" style="width: {{ round($cat->reports_count / $maxCat * 100) }}%; background-color: {{ $cat->color }}"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Quick links --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.users.index') }}" class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 hover:border-purple-200 hover:shadow-md transition group">
            <div class="w-8 h-8 mb-3 text-purple-400 group-hover:text-purple-600 transition">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <p class="font-semibold text-gray-800 group-hover:text-purple-700 transition text-sm">Gérer les utilisateurs</p>
            <p class="text-xs text-gray-400 mt-1">Citoyens, agents, admins</p>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 hover:border-green-200 hover:shadow-md transition group">
            <div class="w-8 h-8 mb-3 text-green-400 group-hover:text-green-600 transition">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
            <p class="font-semibold text-gray-800 group-hover:text-green-700 transition text-sm">Catégories</p>
            <p class="text-xs text-gray-400 mt-1">Types de dégradations</p>
        </a>
        <a href="{{ route('admin.reports.index') }}" class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 hover:border-blue-200 hover:shadow-md transition group">
            <div class="w-8 h-8 mb-3 text-blue-400 group-hover:text-blue-600 transition">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <p class="font-semibold text-gray-800 group-hover:text-blue-700 transition text-sm">Tous les signalements</p>
            <p class="text-xs text-gray-400 mt-1">Voir et filtrer</p>
        </a>
        <a href="{{ route('admin.reports.statistics') }}" class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 hover:border-orange-200 hover:shadow-md transition group">
            <div class="w-8 h-8 mb-3 text-orange-400 group-hover:text-orange-600 transition">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <p class="font-semibold text-gray-800 group-hover:text-orange-700 transition text-sm">Statistiques</p>
            <p class="text-xs text-gray-400 mt-1">Rapports & analyses</p>
        </a>
    </div>
</div>
@endsection
