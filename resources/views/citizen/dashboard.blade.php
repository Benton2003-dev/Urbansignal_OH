@extends('layouts.app')
@section('title', 'Mes signalements')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Mes signalements</h1>
            <p class="text-gray-500 text-sm mt-1">Bonjour, {{ auth()->user()->name }} 👋</p>
        </div>
        <a href="{{ route('citizen.reports.create') }}"
           class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nouveau signalement
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        @php
        $statCards = [
            ['label'=>'Total', 'value'=>$stats['total'], 'color'=>'gray'],
            ['label'=>'En attente', 'value'=>$stats['submitted'], 'color'=>'yellow'],
            ['label'=>'En traitement', 'value'=>$stats['in_progress'], 'color'=>'blue'],
            ['label'=>'Résolus', 'value'=>$stats['resolved'], 'color'=>'green'],
        ];
        @endphp
        @foreach($statCards as $card)
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="text-2xl font-bold text-{{ $card['color'] === 'gray' ? 'gray-900' : $card['color'].'-600' }}">{{ $card['value'] }}</div>
            <div class="text-sm text-gray-500 mt-1">{{ $card['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Reports list --}}
    @if($reports->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-700 mb-2">Aucun signalement</h3>
            <p class="text-gray-400 mb-6">Vous n'avez pas encore fait de signalement.</p>
            <a href="{{ route('citizen.reports.create') }}" class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition">
                Faire mon premier signalement
            </a>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Ticket</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Problème</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Arrondissement</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($reports as $report)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs font-medium text-gray-600 bg-gray-100 px-2 py-1 rounded">{{ $report->ticket_number }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 line-clamp-1">{{ $report->title }}</div>
                                <div class="text-xs text-gray-400">{{ $report->category->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $report->arrondissement->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                @php
                                $colors = ['submitted'=>'bg-gray-100 text-gray-700','validated'=>'bg-blue-100 text-blue-700','in_progress'=>'bg-yellow-100 text-yellow-800','resolved'=>'bg-green-100 text-green-800','archived'=>'bg-slate-100 text-slate-600'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $colors[$report->status] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ $report->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-400">{{ $report->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('citizen.reports.show', $report) }}" class="text-green-600 hover:text-green-800 text-sm font-medium transition">
                                    Voir →
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($reports->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $reports->links() }}
            </div>
            @endif
        </div>
    @endif
</div>
@endsection
