@extends('layouts.app')
@section('title', 'Gérer le signalement ' . $report->ticket_number)

@push('styles')
<style>#manage-map { height: 250px; border-radius: 12px; }</style>
@endpush

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('agent.reports.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Retour aux signalements
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Info card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <span class="font-mono text-xs text-gray-400">{{ $report->ticket_number }}</span>
                        <h1 class="text-xl font-bold text-gray-900 mt-1">{{ $report->title }}</h1>
                        <p class="text-sm text-gray-500 mt-1">{{ $report->category->name }} • {{ $report->arrondissement->name ?? '—' }}</p>
                        <p class="text-xs text-gray-400 mt-1">Soumis par <strong>{{ $report->user->name }}</strong> le {{ $report->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    @php
                    $sc = ['submitted'=>'bg-gray-100 text-gray-700','validated'=>'bg-blue-100 text-blue-700','in_progress'=>'bg-yellow-100 text-yellow-800','resolved'=>'bg-green-100 text-green-800','archived'=>'bg-slate-100 text-slate-600'];
                    $pc = ['low'=>'bg-green-100 text-green-700','medium'=>'bg-yellow-100 text-yellow-700','high'=>'bg-orange-100 text-orange-700','urgent'=>'bg-red-100 text-red-700'];
                    @endphp
                    <div class="flex flex-col gap-2 items-end">
                        <span class="px-3 py-1.5 rounded-full text-sm font-medium {{ $sc[$report->status] ?? '' }}">{{ $report->status_label }}</span>
                        <span class="px-3 py-1.5 rounded-full text-xs font-medium {{ $pc[$report->priority] ?? '' }}">{{ $report->priority_label }}</span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 text-xs">Description</p>
                    <p class="text-gray-700 text-sm leading-relaxed">{{ $report->description }}</p>
                </div>

                @if($report->agent_notes)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Notes de l'agent</p>
                    <p class="text-gray-700 text-sm bg-blue-50 rounded-lg p-3">{{ $report->agent_notes }}</p>
                </div>
                @endif
            </div>

            {{-- Photos --}}
            @if($report->photos->count())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Photos ({{ $report->photos->count() }})</h2>
                <div class="grid grid-cols-3 md:grid-cols-4 gap-3">
                    @foreach($report->photos as $photo)
                    <a href="{{ asset('storage/' . $photo->path) }}" target="_blank">
                        <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->original_name }}"
                             class="w-full h-24 object-cover rounded-lg border border-gray-200 hover:opacity-80 transition">
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Map --}}
            @if($report->latitude && $report->longitude)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Localisation GPS</h2>
                <div id="manage-map"></div>
                @if($report->address)
                <p class="text-sm text-gray-500 mt-2 flex items-center gap-1.5">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $report->address }}
                </p>
                @endif
                <p class="text-xs text-gray-400 mt-1">Lat: {{ $report->latitude }} / Lng: {{ $report->longitude }}</p>
            </div>
            @endif

            {{-- History --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Historique</h2>
                <div class="space-y-3">
                    @foreach($report->statusHistories->sortByDesc('created_at') as $h)
                    <div class="flex items-start gap-3 text-sm">
                        <div class="w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center flex-wrap gap-2">
                                <span class="font-semibold">{{ $h->new_status_label }}</span>
                                @if($h->old_status) <span class="text-gray-400 text-xs">depuis {{ $h->old_status_label }}</span> @endif
                                <span class="text-gray-400 text-xs ml-auto">par {{ $h->changedBy->name ?? '—' }} • {{ $h->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($h->comment)<p class="text-gray-600 text-xs mt-1 bg-gray-50 rounded px-2 py-1">{{ $h->comment }}</p>@endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Sidebar actions --}}
        <div class="space-y-5">
            {{-- Update status --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-semibold text-gray-900 mb-4">Mettre à jour le statut</h2>
                <form action="{{ route('agent.reports.status', $report) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Statut</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                                @foreach(['submitted'=>'Soumis','validated'=>'Validé','in_progress'=>'En cours','resolved'=>'Résolu','archived'=>'Archivé'] as $v => $l)
                                <option value="{{ $v }}" {{ $report->status === $v ? 'selected' : '' }}>{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Priorité</label>
                            <select name="priority" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                                @foreach(['low'=>'Faible','medium'=>'Moyen','high'=>'Élevé','urgent'=>'Urgent'] as $v => $l)
                                <option value="{{ $v }}" {{ $report->priority === $v ? 'selected' : '' }}>{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Notes de l'agent</label>
                            <textarea name="agent_notes" rows="3" placeholder="Notes internes..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 resize-none">{{ $report->agent_notes }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Commentaire (visible dans l'historique)</label>
                            <textarea name="comment" rows="2" placeholder="Expliquez la mise à jour..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"></textarea>
                        </div>
                        <button type="submit" class="w-full py-2.5 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition text-sm">
                            Sauvegarder
                        </button>
                    </div>
                </form>
            </div>

            {{-- Assign team --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-semibold text-gray-900 mb-1">Affecter une équipe</h2>
                @if($report->team)
                <p class="text-xs text-blue-600 mb-3">Équipe actuelle : <strong>{{ $report->team->name }}</strong></p>
                @endif
                <form action="{{ route('agent.reports.assign', $report) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="assigned_team_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 mb-3">
                        <option value="">Sélectionner une équipe...</option>
                        @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ $report->assigned_team_id === $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition text-sm">
                        Affecter l'équipe
                    </button>
                </form>
            </div>

            {{-- Info rapide --}}
            <div class="bg-gray-50 rounded-xl border border-gray-200 p-4 text-sm space-y-2">
                <div class="flex justify-between"><span class="text-gray-500">Citoyen</span><span class="font-medium text-gray-800">{{ $report->user->name }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Tél.</span><span class="font-medium text-gray-800">{{ $report->user->phone ?? '—' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Soumis</span><span class="text-gray-700">{{ $report->created_at->diffForHumans() }}</span></div>
                @if($report->assignedBy)
                <div class="flex justify-between"><span class="text-gray-500">Assigné par</span><span class="font-medium text-gray-800">{{ $report->assignedBy->name }}</span></div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@if($report->latitude && $report->longitude)
@push('scripts')
<script>
window.addEventListener('load', function () {
    const map = L.map('manage-map').setView([{{ $report->latitude }}, {{ $report->longitude }}], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '© OpenStreetMap' }).addTo(map);
    L.marker([{{ $report->latitude }}, {{ $report->longitude }}]).addTo(map).bindPopup('{{ addslashes($report->title) }}').openPopup();
    setTimeout(() => map.invalidateSize(), 200);
});
</script>
@endpush
@endif
