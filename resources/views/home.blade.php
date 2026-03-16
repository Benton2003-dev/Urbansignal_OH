@extends('layouts.app')
@section('title', 'Accueil')

@section('content')

{{-- Hero --}}
<section class="relative bg-gradient-to-br from-green-700 via-green-600 to-emerald-500 text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg viewBox="0 0 100 100" class="w-full h-full" preserveAspectRatio="none">
            <defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/></pattern></defs>
            <rect width="100" height="100" fill="url(#grid)"/>
        </svg>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
        <div class="max-w-3xl">
            <div class="inline-flex items-center px-3 py-1 bg-white/20 backdrop-blur rounded-full text-sm font-medium mb-6">
                <span class="w-2 h-2 bg-green-300 rounded-full mr-2 animate-pulse"></span>
                Commune de Ouidah, Bénin
            </div>
            <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
                Signalez les dégradations de voirie de Ouidah
            </h1>
            <p class="text-xl text-green-100 mb-10 leading-relaxed">
                UrbanSignal permet aux citoyens de signaler facilement les nids-de-poule, routes cassées et autres problèmes de voirie. La mairie intervient plus rapidement grâce à votre signalement.
            </p>
            <div class="flex flex-wrap gap-4">
                @auth
                    <a href="{{ route('citizen.reports.create') }}"
                       class="inline-flex items-center px-6 py-3 bg-white text-green-700 font-semibold rounded-xl shadow-lg hover:bg-green-50 transition transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Faire un signalement
                    </a>
                    <a href="{{ route('citizen.dashboard') }}"
                       class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur text-white font-semibold rounded-xl hover:bg-white/30 transition">
                        Mes signalements
                    </a>
                @else
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center px-6 py-3 bg-white text-green-700 font-semibold rounded-xl shadow-lg hover:bg-green-50 transition transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Créer un compte gratuitement
                    </a>
                    <a href="{{ route('track') }}"
                       class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur text-white font-semibold rounded-xl hover:bg-white/30 transition">
                        Suivre mon ticket
                    </a>
                @endauth
            </div>
        </div>
    </div>

    {{-- Wave --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 60L1440 60L1440 20C1200 60 960 0 720 20C480 40 240 0 0 20L0 60Z" fill="#F9FAFB"/>
        </svg>
    </div>
</section>

{{-- Stats --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-2 py-12">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
            <div class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</div>
            <div class="text-sm text-gray-500 mt-1">Signalements total</div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
            <div class="text-3xl font-bold text-green-600">{{ $stats['resolved'] }}</div>
            <div class="text-sm text-gray-500 mt-1">Problèmes résolus</div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
            <div class="text-3xl font-bold text-yellow-500">{{ $stats['in_progress'] }}</div>
            <div class="text-sm text-gray-500 mt-1">En cours de traitement</div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
            <div class="text-3xl font-bold text-gray-400">{{ $stats['submitted'] }}</div>
            <div class="text-sm text-gray-500 mt-1">En attente</div>
        </div>
    </div>
</section>

{{-- How it works --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900">Comment ça fonctionne ?</h2>
        <p class="text-gray-500 mt-3 max-w-xl mx-auto">En quelques étapes simples, signalez un problème et suivez son traitement en temps réel.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        @php
        $steps = [
            ['num'=>'01','icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z','title'=>'Créez un compte','desc'=>'Inscrivez-vous gratuitement avec votre email et numéro de téléphone.'],
            ['num'=>'02','icon'=>'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z','title'=>'Localisez le problème','desc'=>'Utilisez la géolocalisation GPS ou indiquez l\'adresse exacte.'],
            ['num'=>'03','icon'=>'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z','title'=>'Ajoutez des photos','desc'=>'Prenez des photos du problème pour mieux documenter le signalement.'],
            ['num'=>'04','icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','title'=>'Suivez le traitement','desc'=>'Recevez un numéro de ticket et suivez l\'avancement des réparations.'],
        ];
        @endphp
        @foreach($steps as $i => $step)
        <div class="relative text-center">
            @if($i < 3)
            <div class="hidden md:block absolute top-8 left-1/2 w-full h-0.5 bg-green-100 z-0"></div>
            @endif
            <div class="relative z-10 inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-2xl mb-4">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/>
                </svg>
                <span class="absolute -top-1 -right-1 w-5 h-5 bg-green-600 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ $i+1 }}</span>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">{{ $step['title'] }}</h3>
            <p class="text-sm text-gray-500 leading-relaxed">{{ $step['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- Quick track --}}
<section class="bg-gray-800 text-white py-16">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <h2 class="text-2xl font-bold mb-3">Suivre un signalement</h2>
        <p class="text-gray-400 mb-8">Entrez votre numéro de ticket pour connaître l'état de votre signalement.</p>
        <form action="{{ route('track') }}" method="GET" class="flex gap-3 max-w-md mx-auto">
            <input type="text" name="ticket" placeholder="Ex: US-2024-00001"
                   class="flex-1 px-4 py-3 bg-gray-700 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                   value="{{ request('ticket') }}">
            <button type="submit" class="px-6 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-500 transition whitespace-nowrap">
                Rechercher
            </button>
        </form>
    </div>
</section>

{{-- CTA --}}
@guest
<section class="max-w-4xl mx-auto px-4 py-20 text-center">
    <h2 class="text-3xl font-bold text-gray-900 mb-4">Prêt à améliorer votre commune ?</h2>
    <p class="text-gray-500 mb-8 text-lg">Rejoignez les citoyens de Ouidah qui participent à l'amélioration de leur cadre de vie.</p>
    <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition shadow-lg">
        Commencer maintenant — C'est gratuit
        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
    </a>
</section>
@endguest

@endsection
