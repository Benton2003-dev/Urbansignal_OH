@extends('layouts.app')
@section('title', 'Signalement ' . $report->ticket_number)

@push('styles')
<style>#detail-map { height: 250px; border-radius: 12px; }</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('citizen.dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Retour
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main column --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Header card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                    <div>
                        <p class="font-mono text-xs text-gray-400 mb-1">{{ $report->ticket_number }}</p>
                        <h1 class="text-xl font-bold text-gray-900">{{ $report->title }}</h1>
                        <p class="text-sm text-gray-500 mt-1">{{ $report->category->name }}</p>
                    </div>
                    @php
                    $colors = ['submitted'=>'gray','validated'=>'blue','in_progress'=>'yellow','resolved'=>'green','archived'=>'slate'];
                    $color = $colors[$report->status] ?? 'gray';
                    @endphp
                    <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-{{ $color }}-100 text-{{ $color }}-800">
                        {{ $report->status_label }}
                    </span>
                </div>

                {{-- Progress --}}
                @php
                $steps = ['submitted'=>'Soumis','validated'=>'Validé','in_progress'=>'En cours','resolved'=>'Résolu'];
                $stepKeys = array_keys($steps);
                $currentIdx = array_search($report->status, $stepKeys);
                if ($currentIdx === false) $currentIdx = -1;
                @endphp
                <div class="flex items-center mt-4">
                    @foreach($steps as $key => $label)
                    @php $idx = array_search($key, $stepKeys); @endphp
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold
                            {{ $idx < $currentIdx ? 'bg-green-500 text-white' : ($idx === $currentIdx ? 'bg-blue-700 text-white ring-4 ring-green-100' : 'bg-gray-200 text-gray-400') }}">
                            @if($idx < $currentIdx) ✓ @else {{ $idx+1 }} @endif
                        </div>
                        <p class="text-xs mt-1 {{ $idx <= $currentIdx ? 'text-blue-700 font-medium' : 'text-gray-400' }}">{{ $label }}</p>
                    </div>
                    @if(!$loop->last)
                    <div class="h-0.5 flex-1 -mt-5 {{ $idx < $currentIdx ? 'bg-green-400' : 'bg-gray-200' }}"></div>
                    @endif
                    @endforeach
                </div>
            </div>

            {{-- Description --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Description</h2>
                <p class="text-gray-700 leading-relaxed">{{ $report->description }}</p>
            </div>

            {{-- Photos --}}
            @if($report->photos->count())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Photos ({{ $report->photos->count() }})</h2>
                <div class="grid grid-cols-3 gap-3">
                    @foreach($report->photos as $photo)
                    <a href="{{ asset('storage/' . $photo->path) }}" target="_blank">
                        <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->original_name }}"
                             class="w-full h-28 object-cover rounded-xl border border-gray-200 hover:opacity-90 transition cursor-pointer">
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Map --}}
            @if($report->latitude && $report->longitude)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Localisation</h2>
                <div id="detail-map"></div>
                @if($report->address)
                <p class="text-sm text-gray-500 mt-2 flex items-center gap-1.5">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $report->address }}
                </p>
                @endif
            </div>
            @endif

            {{-- History --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Historique du suivi</h2>
                <div class="space-y-4">
                    @foreach($report->statusHistories->sortByDesc('created_at') as $history)
                    <div class="flex items-start gap-3">
                        <div class="mt-1 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-sm font-semibold text-gray-800">{{ $history->new_status_label }}</span>
                                @if($history->old_status)
                                <span class="text-xs text-gray-400">depuis : {{ $history->old_status_label }}</span>
                                @endif
                                <span class="text-xs text-gray-400 ml-auto">{{ $history->created_at->diffForHumans() }}</span>
                            </div>
                            @if($history->comment)
                            <p class="text-sm text-gray-600 mt-1 bg-gray-50 rounded-lg px-3 py-2">{{ $history->comment }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Informations</h2>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs text-gray-400">Catégorie</dt>
                        <dd class="text-sm font-medium text-gray-800">{{ $report->category->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400">Arrondissement</dt>
                        <dd class="text-sm font-medium text-gray-800">{{ $report->arrondissement->name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400">Priorité</dt>
                        <dd class="text-sm font-medium text-gray-800">{{ $report->priority_label }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400">Date de soumission</dt>
                        <dd class="text-sm text-gray-800">{{ $report->created_at->format('d/m/Y à H:i') }}</dd>
                    </div>
                    @if($report->team)
                    <div>
                        <dt class="text-xs text-gray-400">Équipe assignée</dt>
                        <dd class="text-sm font-medium text-blue-700">{{ $report->team->name }}</dd>
                    </div>
                    @endif
                    @if($report->resolved_at)
                    <div>
                        <dt class="text-xs text-gray-400">Résolu le</dt>
                        <dd class="text-sm font-medium text-blue-700">{{ $report->resolved_at->format('d/m/Y') }}</dd>
                    </div>
                    @endif
                </dl>
            </div>

            <div class="bg-blue-50 rounded-xl border border-blue-100 p-4">
                <p class="text-xs font-semibold text-blue-800 mb-1">Numéro de ticket</p>
                <p class="font-mono text-lg font-bold text-blue-700">{{ $report->ticket_number }}</p>
                <p class="text-xs text-blue-600 mt-2">Partagez ce numéro avec la mairie si vous souhaitez un suivi téléphonique.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@if($report->latitude && $report->longitude)
@push('scripts')
<script>
window.addEventListener('load', function () {
    const map = L.map('detail-map').setView([{{ $report->latitude }}, {{ $report->longitude }}], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap', maxZoom: 19
    }).addTo(map);
    setTimeout(() => map.invalidateSize(), 200);
    L.marker([{{ $report->latitude }}, {{ $report->longitude }}])
        .addTo(map)
        .bindPopup('<strong>{{ addslashes($report->title) }}</strong>').openPopup();
});
</script>
@endpush
@endif
