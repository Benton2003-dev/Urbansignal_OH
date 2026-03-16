@extends('layouts.app')
@section('title', 'Suivre un signalement')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-gray-900">Suivre mon signalement</h1>
        <p class="text-gray-500 mt-2">Entrez votre numéro de ticket pour consulter l'état de votre signalement.</p>
    </div>

    {{-- Search form --}}
    <form action="{{ route('track') }}" method="GET" class="flex gap-3 mb-10">
        <input type="text" name="ticket" placeholder="Ex: US-2024-00001"
               value="{{ request('ticket') }}"
               class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-gray-900"
               required>
        <button type="submit" class="px-6 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition">
            Rechercher
        </button>
    </form>

    {{-- Not found --}}
    @if(request('ticket') && !$report)
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
            <svg class="w-12 h-12 text-yellow-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-yellow-800 font-medium">Ticket introuvable</p>
            <p class="text-yellow-600 text-sm mt-1">Aucun signalement trouvé avec le numéro <strong>{{ request('ticket') }}</strong>.</p>
        </div>
    @endif

    {{-- Report found --}}
    @if($report)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Header --}}
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="text-xs text-gray-500 font-mono mb-1">{{ $report->ticket_number }}</p>
                    <h2 class="text-xl font-bold text-gray-900">{{ $report->title }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $report->category->name }} • {{ $report->arrondissement->name ?? 'N/A' }}</p>
                </div>
                @php
                $statusColors = ['submitted'=>'gray','validated'=>'blue','in_progress'=>'yellow','resolved'=>'green','archived'=>'slate'];
                $statusLabels = ['submitted'=>'Soumis','validated'=>'Validé','in_progress'=>'En cours','resolved'=>'Résolu','archived'=>'Archivé'];
                $color = $statusColors[$report->status] ?? 'gray';
                @endphp
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-{{ $color }}-100 text-{{ $color }}-800">
                    @if($report->status === 'resolved') ✓ @elseif($report->status === 'in_progress') ⟳ @endif
                    {{ $statusLabels[$report->status] ?? $report->status }}
                </span>
            </div>
        </div>

        {{-- Progress timeline --}}
        <div class="px-6 py-5 bg-gray-50 border-b border-gray-100">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Progression</p>
            <div class="flex items-center justify-between">
                @php
                $steps = ['submitted' => 'Soumis', 'validated' => 'Validé', 'in_progress' => 'En cours', 'resolved' => 'Résolu'];
                $currentIndex = array_search($report->status, array_keys($steps));
                if ($currentIndex === false) $currentIndex = -1;
                @endphp
                @foreach($steps as $key => $label)
                    @php $idx = array_search($key, array_keys($steps)); @endphp
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                            {{ $idx <= $currentIndex ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-400' }}">
                            @if($idx < $currentIndex)
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            @else
                                {{ $idx + 1 }}
                            @endif
                        </div>
                        <p class="text-xs mt-1 text-center {{ $idx <= $currentIndex ? 'text-green-700 font-medium' : 'text-gray-400' }}">{{ $label }}</p>
                    </div>
                    @if(!$loop->last)
                        <div class="h-0.5 flex-1 -mt-4 {{ $idx < $currentIndex ? 'bg-green-400' : 'bg-gray-200' }}"></div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Details --}}
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Description</p>
                <p class="text-sm text-gray-700 leading-relaxed">{{ $report->description }}</p>
            </div>
            <div class="space-y-3">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Date de signalement</p>
                    <p class="text-sm text-gray-700">{{ $report->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                @if($report->address)
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Adresse</p>
                    <p class="text-sm text-gray-700">{{ $report->address }}</p>
                </div>
                @endif
                @if($report->resolved_at)
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Résolu le</p>
                    <p class="text-sm text-green-700 font-medium">{{ $report->resolved_at->format('d/m/Y à H:i') }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Photos --}}
        @if($report->photos->count())
        <div class="px-6 pb-4 border-t border-gray-100 pt-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Photos</p>
            <div class="flex gap-3 flex-wrap">
                @foreach($report->photos as $photo)
                <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->original_name }}"
                     class="w-24 h-24 object-cover rounded-lg border border-gray-200 cursor-pointer hover:opacity-90 transition">
                @endforeach
            </div>
        </div>
        @endif

        {{-- History --}}
        @if($report->statusHistories->count())
        <div class="px-6 pb-6 border-t border-gray-100 pt-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Historique</p>
            <div class="space-y-3">
                @foreach($report->statusHistories->sortByDesc('created_at') as $history)
                <div class="flex items-start gap-3">
                    <div class="w-2 h-2 rounded-full bg-green-500 mt-2 flex-shrink-0"></div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-medium text-gray-800">{{ $history->new_status_label }}</span>
                            @if($history->old_status)
                            <span class="text-xs text-gray-400">← {{ $history->old_status_label }}</span>
                            @endif
                        </div>
                        @if($history->comment)
                        <p class="text-xs text-gray-500 mt-0.5">{{ $history->comment }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-0.5">{{ $history->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @endif
</div>
@endsection
