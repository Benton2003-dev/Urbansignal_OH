@extends('layouts.app')
@section('title', 'Signalement ' . $report->ticket_number . ' — Admin')

@push('styles')
<style>#admin-map { height: 250px; border-radius: 12px; }</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Retour aux signalements
        </a>
    </div>

    {{-- Badge admin --}}
    <div class="mb-4 inline-flex items-center gap-1.5 px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        Vue administrateur — lecture seule
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <p class="font-mono text-xs text-gray-400">{{ $report->ticket_number }}</p>
                        <h1 class="text-xl font-bold text-gray-900 mt-1">{{ $report->title }}</h1>
                        <p class="text-sm text-gray-500 mt-1">{{ $report->category->name }} • {{ $report->arrondissement->name ?? '—' }}</p>
                    </div>
                    @php $sc=['submitted'=>'bg-gray-100 text-gray-700','validated'=>'bg-blue-100 text-blue-700','in_progress'=>'bg-yellow-100 text-yellow-800','resolved'=>'bg-green-100 text-blue-800','archived'=>'bg-slate-100 text-slate-600']; @endphp
                    <span class="px-3 py-1.5 rounded-full text-sm font-medium {{ $sc[$report->status]??'' }}">{{ $report->status_label }}</span>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $report->description }}</p>
                </div>
            </div>

            @if($report->photos->count())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xs font-semibold text-gray-500 uppercase mb-3">Photos</h2>
                <div class="grid grid-cols-4 gap-3">
                    @foreach($report->photos as $photo)
                    <a href="{{ asset('storage/' . $photo->path) }}" target="_blank">
                        <img src="{{ asset('storage/' . $photo->path) }}" class="w-full h-24 object-cover rounded-lg border border-gray-200 hover:opacity-80 transition">
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            @if($report->latitude && $report->longitude)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xs font-semibold text-gray-500 uppercase mb-3">Localisation</h2>
                <div id="admin-map"></div>
            </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xs font-semibold text-gray-500 uppercase mb-4">Historique</h2>
                <div class="space-y-3">
                    @foreach($report->statusHistories->sortByDesc('created_at') as $h)
                    <div class="flex items-start gap-3 text-sm">
                        <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                        </div>
                        <div>
                            <span class="font-semibold">{{ $h->new_status_label }}</span>
                            @if($h->old_status)<span class="text-gray-400 text-xs ml-1">depuis {{ $h->old_status_label }}</span>@endif
                            <span class="text-gray-400 text-xs ml-2">par {{ $h->changedBy->name ?? '—' }} • {{ $h->created_at->format('d/m/Y H:i') }}</span>
                            @if($h->comment)<p class="text-gray-500 text-xs mt-0.5">{{ $h->comment }}</p>@endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-5">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-semibold text-gray-900 mb-4 text-sm">Détails</h2>
                <dl class="space-y-2.5 text-sm">
                    <div class="flex justify-between"><dt class="text-gray-400">Citoyen</dt><dd class="font-medium text-gray-800">{{ $report->user->name }}</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-400">Email</dt><dd class="text-gray-700 text-xs">{{ $report->user->email }}</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-400">Téléphone</dt><dd class="text-gray-700">{{ $report->user->phone ?? '—' }}</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-400">Priorité</dt><dd class="font-medium text-gray-800">{{ $report->priority_label }}</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-400">Équipe</dt><dd class="font-medium text-blue-700">{{ $report->team->name ?? '—' }}</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-400">Assigné par</dt><dd class="text-gray-700">{{ $report->assignedBy->name ?? '—' }}</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-400">Soumis le</dt><dd class="text-gray-700">{{ $report->created_at->format('d/m/Y') }}</dd></div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection

@if($report->latitude && $report->longitude)
@push('scripts')
<script>
window.addEventListener('load', function () {
    const map = L.map('admin-map').setView([{{ $report->latitude }}, {{ $report->longitude }}], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '© OpenStreetMap' }).addTo(map);
    L.marker([{{ $report->latitude }}, {{ $report->longitude }}]).addTo(map).bindPopup('{{ addslashes($report->title) }}').openPopup();
    setTimeout(() => map.invalidateSize(), 200);
});
</script>
@endpush
@endif
