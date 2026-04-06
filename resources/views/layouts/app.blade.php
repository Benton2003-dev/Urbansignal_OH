<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'UrbanSignal') — Commune de Ouidah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;900&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm border-b border-gray-200" x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                {{-- Logo --}}
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('images/logo.svg') }}" alt="UrbanSignal" class="h-9 w-auto">
                        <div>
                            <span class="font-bold text-lg text-gray-900 leading-none">UrbanSignal</span>
                            <p class="text-xs text-gray-400 leading-none">Commune de Ouidah</p>
                        </div>
                    </a>
                </div>

                {{-- Desktop nav --}}
                <div class="hidden md:flex items-center space-x-1">
                    @auth
                        @if(auth()->user()->isSuperAdmin())
                            <a href="{{ route('superadmin.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">Dashboard</a>
                            <a href="{{ route('superadmin.users') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">Utilisateurs</a>
                            <a href="{{ route('superadmin.maintenance') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">Maintenance</a>
                            <a href="{{ route('superadmin.settings') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">Paramètres</a>
                        @elseif(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">Tableau de bord</a>
                            <a href="{{ route('admin.reports.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">Signalements</a>
                            <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">Utilisateurs</a>
                            <a href="{{ route('admin.domains.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">Domaines</a>
                            <a href="{{ route('admin.teams.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">Équipes</a>
                            <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">Catégories</a>
                        @elseif(auth()->user()->isAgent())
                            <a href="{{ route('agent.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">Tableau de bord</a>
                            <a href="{{ route('agent.reports.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">Signalements</a>
                            <a href="{{ route('agent.reports.map') }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                                Carte
                            </a>
                        @else
                            <a href="{{ route('citizen.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">Mes signalements</a>
                            <a href="{{ route('citizen.reports.create') }}" class="px-3 py-2 rounded-md text-sm font-medium text-blue-700 hover:bg-blue-50 transition">+ Signaler un problème</a>
                            <a href="{{ route('track') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">Suivi ticket</a>
                        @endif

                        {{-- User dropdown --}}
                        <div class="relative ml-2" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-700 text-sm font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ explode(' ', auth()->user()->name)[0] }}</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                 class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-200 z-50 overflow-hidden">
                                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                                    <p class="text-xs text-gray-500">Connecté en tant que</p>
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                    <span class="inline-block mt-1 px-2 py-0.5 text-xs rounded-full font-medium
                                        {{ auth()->user()->isSuperAdmin() ? 'bg-red-100 text-red-700' : (auth()->user()->isAdmin() ? 'bg-purple-100 text-purple-700' : (auth()->user()->isAgent() ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-blue-700')) }}">
                                        {{ auth()->user()->isSuperAdmin() ? 'Super Admin' : (auth()->user()->isAdmin() ? 'Administrateur' : (auth()->user()->isAgent() ? 'Agent technique' : 'Citoyen')) }}
                                    </span>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Mon profil
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('track') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">Suivi ticket</a>
                        <a href="{{ route('login') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">Connexion</a>
                        <a href="{{ route('register') }}" class="ml-1 px-4 py-2 bg-blue-700 text-white text-sm font-semibold rounded-lg hover:bg-blue-800 transition shadow-sm">S'inscrire</a>
                    @endauth
                </div>

                {{-- Mobile button --}}
                <div class="md:hidden flex items-center">
                    <button @click="mobileOpen = !mobileOpen" class="p-2 rounded-md text-gray-400 hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div x-show="mobileOpen" class="md:hidden border-t border-gray-200 bg-white px-4 py-3 space-y-1">
            @auth
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">Tableau de bord</a>
                <a href="{{ route('track') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">Suivi ticket</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-sm font-medium text-red-600 hover:bg-red-50">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">Connexion</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-blue-700 hover:bg-blue-50">S'inscrire</a>
            @endauth
        </div>
    </nav>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            <div class="flex items-center p-4 bg-green-50 border border-green-200 rounded-lg text-blue-800 text-sm">
                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            <div class="flex items-center p-4 bg-red-50 border border-red-200 rounded-lg text-red-800 text-sm">
                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Main content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-gray-400 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-3">
                        <div class="w-8 h-8 bg-blue-700 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                        </div>
                        <span class="text-white font-bold">UrbanSignal</span>
                    </div>
                    <p class="text-sm leading-relaxed">Plateforme de signalement des dégradations de voirie pour la commune de Ouidah, Bénin.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3">Liens utiles</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Accueil</a></li>
                        <li><a href="{{ route('track') }}" class="hover:text-white transition">Suivre un signalement</a></li>
                        @guest
                            <li><a href="{{ route('register') }}" class="hover:text-white transition">Créer un compte</a></li>
                            <li><a href="{{ route('login') }}" class="hover:text-white transition">Se connecter</a></li>
                        @endguest
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3">Mairie de Ouidah</h4>
                    <p class="text-sm">Place du Gouverneur, Ouidah, Bénin</p>
                    <p class="text-sm mt-1">Tél : +229 22 34 10 91</p>
                    <p class="text-sm mt-1">contact@mairie-ouidah.bj</p>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-xs">
                &copy; {{ date('Y') }} Commune de Ouidah — UrbanSignal. Tous droits réservés.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
