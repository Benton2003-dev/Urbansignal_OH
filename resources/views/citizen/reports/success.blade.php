@extends('layouts.app')
@section('title', 'Signalement soumis')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
    </div>

    <h1 class="text-3xl font-bold text-gray-900 mb-3">Signalement soumis !</h1>
    <p class="text-gray-500 mb-8 text-lg">Votre signalement a bien été enregistré. La mairie de Ouidah en prendra connaissance prochainement.</p>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8 text-left">
        <div class="text-center mb-6">
            <p class="text-sm text-gray-500 mb-2">Votre numéro de ticket</p>
            <div class="inline-block px-6 py-3 bg-green-50 border-2 border-green-200 rounded-xl">
                <span class="font-mono text-2xl font-bold text-blue-700">{{ $report->ticket_number }}</span>
            </div>
            <p class="text-xs text-gray-400 mt-2">Conservez ce numéro pour suivre l'avancement de votre signalement.</p>
        </div>

        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-100">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Type de problème</p>
                <p class="text-sm text-gray-800">{{ $report->category->name }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Arrondissement</p>
                <p class="text-sm text-gray-800">{{ $report->arrondissement->name ?? '—' }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Titre</p>
                <p class="text-sm text-gray-800">{{ $report->title }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Statut</p>
                <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">Soumis</span>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Date</p>
                <p class="text-sm text-gray-800">{{ $report->created_at->format('d/m/Y à H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap justify-center gap-4">
        <a href="{{ route('citizen.reports.show', $report) }}"
           class="inline-flex items-center px-6 py-3 bg-blue-700 text-white font-semibold rounded-xl hover:bg-blue-800 transition">
            Voir mon signalement →
        </a>
        <a href="{{ route('citizen.dashboard') }}"
           class="inline-flex items-center px-6 py-3 border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
            Mes signalements
        </a>
        <a href="{{ route('citizen.reports.create') }}"
           class="inline-flex items-center px-6 py-3 border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
            + Nouveau signalement
        </a>
    </div>
</div>
@endsection
