<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.svg') }}">
    <title>@yield('title', 'UrbanSignal') - Commune de Ouidah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    /* ── Design Tokens ── */
    :root {
        --sand:   #F4F7FC;
        --navy:   #1B2F6E;
        --royal:  #2952A3;
        --sky:    #5B9BD5;
        --gold:   #E8B84B;
        --ink:    #0D1B3E;
        --smoke:  #6B7FA3;
        --mist:   #EBF1FA;
        --line:   rgba(27,47,110,.09);
        --white:  #FFFFFF;

        /* Aliases */
        --blue:   var(--navy);
        --clay:   var(--gold);
        --amber:  var(--gold);
        --olive:  #3A6B4E;
        --forest: #2D5A3D;
    }

    [x-cloak] { display: none !important; }

    *, *::before, *::after { box-sizing: border-box; }

    html { scroll-behavior: smooth; }

    body {
        font-family: 'Outfit', sans-serif;
        background: var(--sand);
        color: var(--ink);
        -webkit-font-smoothing: antialiased;
        margin: 0;
    }

    /* ════════════════════════════
       NAVBAR
    ════════════════════════════ */
    .us-nav {
        position: sticky; top: 0; z-index: 100;
        background: #FFFFFF;
        backdrop-filter: blur(16px);
        border-bottom: 1px solid rgba(27,47,110,.08);
        box-shadow: 0 1px 12px rgba(27,47,110,.06);
    }

    .us-nav__inner {
        max-width: 1280px; margin: 0 auto;
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 2rem; height: 64px;
    }

    /* Logo */
    .us-nav__logo {
        display: flex; align-items: center; gap: .5rem;
        text-decoration: none; flex-shrink: 0;
    }

    .us-nav__mark {
        width: 40px; height: 40px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .us-nav__mark img {
        width: 100%; height: auto;
        display: block;
    }

    .us-nav__brand {
        display: flex; flex-direction: column; line-height: 1;
    }

    .us-nav__brand-name {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900; font-size: 1.1rem;
        color: #000; letter-spacing: -.01em;
    }
    .us-nav__brand-name em { font-style: italic; color: var(--amber); }

    .us-nav__brand-sub {
        font-size: .62rem; font-weight: 400;
        letter-spacing: .08em; text-transform: uppercase;
        color: var(--smoke);
        margin-top: .12rem;
    }

    /* Desktop Links */
    .us-nav__links {
        display: flex; align-items: center; gap: .15rem;
    }

    .us-nav__link {
        font-size: .85rem; font-weight: 500;
        color: var(--ink);
        text-decoration: none;
        padding: .5rem .85rem;
        border-radius: 8px;
        transition: background .18s, color .18s;
        display: inline-flex; align-items: center; gap: .4rem;
        white-space: nowrap;
    }
    .us-nav__link:hover {
        color: var(--navy);
        background: var(--mist);
    }
    .us-nav__link--accent {
        color: #16a34a;
        font-weight: 600;
    }
    .us-nav__link--accent:hover { color: #15803d; background: rgba(22,163,74,.08); }

    .us-nav__divider {
        width: 1px; height: 20px;
        background: var(--line);
        margin: 0 .35rem;
    }

    .us-nav__btn {
        display: inline-flex; align-items: center; gap: .45rem;
        background: var(--clay); color: #fff;
        font-family: 'Outfit', sans-serif;
        font-weight: 600; font-size: .83rem;
        padding: .5rem 1.1rem; border-radius: 9px;
        text-decoration: none; margin-left: .35rem;
        box-shadow: 0 3px 14px rgba(232,184,75,.32);
        transition: background .18s, transform .18s, box-shadow .18s;
    }
    .us-nav__btn:hover {
        background: #d4a73c;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(232,184,75,.4);
    }

    /* User dropdown */
    .us-nav__user {
        position: relative; margin-left: .5rem;
    }

    .us-nav__user-btn {
        display: flex; align-items: center; gap: .55rem;
        padding: .4rem .75rem .4rem .45rem;
        border-radius: 10px; border: none; cursor: pointer;
        background: var(--mist);
        border: 1px solid var(--line);
        transition: background .18s, border-color .18s;
    }
    .us-nav__user-btn:hover {
        background: #dde8f5;
        border-color: rgba(41,82,163,.2);
    }

    .us-nav__avatar {
        width: 30px; height: 30px;
        border-radius: 8px;
        background: var(--royal);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Playfair Display', serif;
        font-weight: 700; font-size: .85rem;
        color: #fff;
    }

    .us-nav__user-name {
        font-size: .83rem; font-weight: 500;
        color: var(--ink);
    }

    .us-nav__user-caret {
        color: var(--smoke);
        transition: transform .2s;
    }
    .us-nav__user-btn[aria-expanded="true"] .us-nav__user-caret {
        transform: rotate(180deg);
    }

    /* Dropdown panel */
    .us-nav__dropdown {
        position: absolute; right: 0; top: calc(100% + .5rem);
        width: 220px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(13,27,62,.14);
        border: 1px solid var(--line);
        overflow: hidden;
        z-index: 200;
    }

    .us-nav__dropdown-head {
        padding: .85rem 1rem;
        background: var(--mist);
        border-bottom: 1px solid var(--line);
    }

    .us-nav__dropdown-context {
        font-size: .68rem; font-weight: 500;
        letter-spacing: .1em; text-transform: uppercase;
        color: var(--smoke); margin-bottom: .2rem;
    }

    .us-nav__dropdown-name {
        font-size: .88rem; font-weight: 600;
        color: var(--ink);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    .us-nav__role {
        display: inline-flex; align-items: center;
        margin-top: .35rem; padding: .18rem .6rem;
        border-radius: 999px;
        font-size: .68rem; font-weight: 600;
        letter-spacing: .05em; text-transform: uppercase;
    }
    .us-nav__role--admin   { background: rgba(124,58,237,.1); color: #6D28D9; }
    .us-nav__role--agent   { background: rgba(37,99,235,.1);  color: #1D4ED8; }
    .us-nav__role--citizen { background: rgba(58,107,78,.12); color: var(--olive); }

    .us-nav__dropdown-item {
        display: flex; align-items: center; gap: .6rem;
        padding: .75rem 1rem;
        font-size: .85rem; font-weight: 400;
        color: var(--ink); text-decoration: none;
        border: none; background: none; cursor: pointer; width: 100%;
        text-align: left;
        transition: background .15s;
    }
    .us-nav__dropdown-item:hover { background: var(--mist); }
    .us-nav__dropdown-item svg { color: var(--smoke); flex-shrink: 0; }
    .us-nav__dropdown-item--danger { color: #DC2626; }
    .us-nav__dropdown-item--danger:hover { background: #FEF2F2; }
    .us-nav__dropdown-item--danger svg { color: #DC2626; }

    .us-nav__dropdown-sep {
        height: 1px; background: var(--line); margin: .25rem 0;
    }

    /* Mobile toggle */
    .us-nav__mobile-btn {
        display: none;
        padding: .45rem; border-radius: 8px; border: none;
        background: var(--mist); cursor: pointer;
        color: var(--ink);
        transition: background .18s;
        align-items: center; justify-content: center;
    }
    .us-nav__mobile-btn:hover { background: #dde8f5; }

    /* ════════════════════════════
       RESPONSIVE BREAKPOINTS
    ════════════════════════════ */

    /* ── Tablette large (max 1024px) ── */
    @media (max-width: 1024px) {
        .us-nav__inner { padding: 0 1.5rem; }
        .us-nav__link  { padding: .45rem .65rem; font-size: .8rem; }
        .us-nav__brand-sub { display: none; }
    }

    /* ── Tablette (max 768px) — menu hamburger ── */
    @media (max-width: 768px) {
        .us-nav__links     { display: none !important; }
        .us-nav__mobile-btn { display: flex !important; }
        .us-nav__inner     { padding: 0 1rem; height: 56px; }
        .us-nav__brand-name { font-size: 1rem; }
        .us-nav__mark      { width: 34px; height: 34px; }
    }

    /* ── Mobile (max 480px) ── */
    @media (max-width: 480px) {
        .us-nav__brand-name { font-size: .92rem; }
        .us-nav__inner { height: 52px; }
    }

    /* ── Mobile drawer ── */
    .us-nav__mobile {
        display: block;
        background: #FFFFFF;
        border-top: 1px solid var(--line);
        padding: .5rem 1rem 1.25rem;
        animation: slideDown 0.25s ease-out;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .us-nav__mobile-link {
        display: flex; align-items: center; gap: .5rem;
        padding: .75rem 1rem; border-radius: 8px;
        font-size: .95rem; font-weight: 500;
        color: var(--ink); text-decoration: none;
        transition: background .15s, color .15s;
        width: 100%;
    }
    .us-nav__mobile-link:hover   { background: var(--mist); color: var(--navy); }
    .us-nav__mobile-link:active  { background: rgba(41,82,163,.1); }

    .us-nav__mobile-sep {
        height: 1px; background: var(--line);
        margin: .75rem 0;
    }

    .us-nav__mobile-btn-action {
        display: flex; align-items: center; gap: .5rem;
        padding: .75rem 1rem; border-radius: 8px;
        font-size: .95rem; font-weight: 600;
        color: #fff; text-decoration: none;
        background: var(--royal);
        margin-top: .5rem;
        border: none; cursor: pointer; width: 100%;
        transition: background .15s;
        justify-content: center;
    }
    .us-nav__mobile-btn-action:hover { background: #1E3F7F; }
    .us-nav__mobile-btn-action--danger {
        background: #DC2626;
    }
    .us-nav__mobile-btn-action--danger:hover { background: #B91C1C; }

    /* ════════════════════════════
       FLASH MESSAGES
    ════════════════════════════ */
    .us-flash {
        max-width: 1280px; margin: 0 auto;
        padding: 1rem 2rem 0;
    }

    @media (max-width: 768px) { .us-flash { padding: .75rem 1rem 0; } }

    .us-alert {
        display: flex; align-items: flex-start; gap: .75rem;
        padding: .9rem 1.1rem;
        border-radius: 12px;
        font-size: .88rem; font-weight: 400;
        line-height: 1.5;
        animation: us-alertIn .4s cubic-bezier(.22,1,.36,1) both;
    }
    @keyframes us-alertIn {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .us-alert--success {
        background: rgba(43,209,111,.18);
        border: 1px solid rgba(43,209,111,.3);
        color: #166534;
    }
    .us-alert--error {
        background: rgba(220,38,38,.07);
        border: 1px solid rgba(220,38,38,.18);
        color: #B91C1C;
    }
    .us-alert__icon { flex-shrink: 0; margin-top: .05rem; }

    /* ════════════════════════════
       MAIN
    ════════════════════════════ */
    .us-main { min-height: calc(100vh - 56px); }

    /* ════════════════════════════
       FOOTER
    ════════════════════════════ */
    .us-footer {
        background: var(--ink);
    }

    .us-footer__top {
        max-width: 1280px; margin: 0 auto;
        padding: 4rem 2rem 3rem;
        display: grid;
        grid-template-columns: 1.4fr 1fr 1fr;
        gap: 3rem;
    }

    /* Tablette */
    @media (max-width: 1024px) {
        .us-footer__top {
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            padding: 3rem 1.5rem 2rem;
        }
        /* Brand prend toute la largeur sur tablette */
        .us-footer__top > div:first-child {
            grid-column: 1 / -1;
        }
    }

    /* Mobile */
    @media (max-width: 768px) {
        .us-footer__top {
            grid-template-columns: 1fr;
            gap: 1.75rem;
            padding: 2.5rem 1.25rem 2rem;
        }
        .us-footer__top > div:first-child {
            grid-column: auto;
        }
    }

    .us-footer__brand {
        background: rgba(255,255,255,.07);
        border-radius: 12px;
        display: flex; align-items: center; gap: .6rem;
        padding: .6rem .85rem;
        margin-bottom: 1rem;
        width: fit-content;
    }

    .us-footer__mark {
        width: 40px; height: 40px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .us-footer__mark img { width: 100%; height: auto; }

    .us-footer__brand-name {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900; font-size: 1.1rem;
        color: #FFFFFF; letter-spacing: -.01em;
    }
    .us-footer__brand-name em { font-style: italic; color: var(--amber); }

    .us-footer__desc {
        font-size: .84rem; line-height: 1.7;
        color: rgba(255,255,255,.35); font-weight: 300;
        max-width: 300px;
    }

    @media (max-width: 768px) {
        .us-footer__desc { max-width: 100%; }
    }

    .us-footer__col-title {
        font-family: 'Outfit', sans-serif;
        font-size: .72rem; font-weight: 600;
        letter-spacing: .14em; text-transform: uppercase;
        color: rgba(255,255,255,.35);
        margin-bottom: 1rem; display: block;
    }

    .us-footer__oh-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 5px;
    }

    .us-footer__oh-mark img {
        height: 35px;
        width: auto;
        object-fit: contain;
        border-radius: 4px;
    }

    .us-footer__links {
        display: flex; flex-direction: column; gap: .5rem;
    }

    .us-footer__link {
        font-size: .85rem; font-weight: 400;
        color: rgba(255,255,255,.45); text-decoration: none;
        transition: color .18s;
    }
    .us-footer__link:hover { color: rgba(255,255,255,.8); }

    .us-footer__contact-item {
        display: flex; align-items: flex-start; gap: .5rem;
        font-size: .84rem; color: rgba(255,255,255,.4);
        font-weight: 300; margin-bottom: .5rem; line-height: 1.4;
    }
    .us-footer__contact-item svg { flex-shrink: 0; margin-top: .1rem; opacity: .5; }
    .us-footer__contact-item a  { color: rgba(255,255,255,.4); text-decoration: none; }
    .us-footer__contact-item a:hover { color: rgba(255,255,255,.7); }

    .us-footer__bottom {
        border-top: 1px solid rgba(255,255,255,.07);
    }

    .us-footer__bottom-inner {
        max-width: 1280px; margin: 0 auto;
        padding: 1.25rem 2rem;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: .75rem;
    }

    @media (max-width: 768px) {
        .us-footer__bottom-inner {
            padding: 1rem 1.25rem;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
    }

    .us-footer__copy {
        font-size: .75rem; color: rgba(255,255,255,.22);
        font-weight: 300;
    }

    .us-footer__bottom-links {
        display: flex; gap: 1.5rem;
    }
    .us-footer__bottom-link {
        font-size: .75rem; color: rgba(255,255,255,.25);
        text-decoration: none; transition: color .18s;
    }
    .us-footer__bottom-link:hover { color: rgba(255,255,255,.55); }
    </style>

    @stack('styles')
</head>
<body>

{{-- ════════════════════════════
     NAVBAR
════════════════════════════ --}}
<nav class="us-nav" x-data="{ mobileOpen: false }">
    <div class="us-nav__inner">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="us-nav__logo">
            <div class="us-nav__mark">
                <img src="{{ asset('images/logo.svg') }}" alt="UrbanSignal Logo">
            </div>
            <div class="us-nav__brand">
                <span class="us-nav__brand-name">Urban<em>Signal</em></span>
                <span class="us-nav__brand-sub">Commune de Ouidah</span>
            </div>
        </a>

        {{-- Desktop links --}}
        <div class="us-nav__links">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="us-nav__link">Tableau de bord</a>
                    <a href="{{ route('admin.reports.index') }}" class="us-nav__link">Signalements</a>
                    <a href="{{ route('admin.users.index') }}" class="us-nav__link">Utilisateurs</a>
                    <a href="{{ route('admin.categories.index') }}" class="us-nav__link">Catégories</a>
                @elseif(auth()->user()->isAgent())
                    <a href="{{ route('agent.dashboard') }}" class="us-nav__link">Tableau de bord</a>
                    <a href="{{ route('agent.reports.index') }}" class="us-nav__link">Signalements</a>
                    <a href="{{ route('agent.reports.map') }}" class="us-nav__link">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        Carte
                    </a>
                @else
                    <a href="{{ route('citizen.dashboard') }}" class="us-nav__link">Mes signalements</a>
                    <a href="{{ route('citizen.reports.create') }}" class="us-nav__link us-nav__link--accent">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Signaler
                    </a>
                    <a href="{{ route('track') }}" class="us-nav__link">Suivi ticket</a>
                @endif

                <div class="us-nav__divider"></div>

                {{-- User dropdown --}}
                <div class="us-nav__user" x-data="{ open: false }">
                    <button class="us-nav__user-btn" @click.stop="open = !open" :aria-expanded="open.toString()">
                        <div class="us-nav__avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        <span class="us-nav__user-name">{{ explode(' ', auth()->user()->name)[0] }}</span>
                        <svg class="us-nav__user-caret" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div class="us-nav__dropdown"
                         x-show="open"
                         x-cloak
                         @click.outside="open = false"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1">
                        <div class="us-nav__dropdown-head">
                            <div class="us-nav__dropdown-context">Connecté en tant que</div>
                            <div class="us-nav__dropdown-name">{{ auth()->user()->name }}</div>
                            @php
                                $roleClass = auth()->user()->isAdmin() ? 'admin' : (auth()->user()->isAgent() ? 'agent' : 'citizen');
                                $roleLabel = auth()->user()->isAdmin() ? 'Administrateur' : (auth()->user()->isAgent() ? 'Agent technique' : 'Citoyen');
                            @endphp
                            <span class="us-nav__role us-nav__role--{{ $roleClass }}">{{ $roleLabel }}</span>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="us-nav__dropdown-item">
                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Mon profil
                        </a>

                        <div class="us-nav__dropdown-sep"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="us-nav__dropdown-item us-nav__dropdown-item--danger">
                                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>

            @else
                <a href="{{ route('track') }}" class="us-nav__link">Suivi ticket</a>
                <div class="us-nav__divider"></div>
                <a href="{{ route('login') }}" class="us-nav__link">Connexion</a>
                <a href="{{ route('register') }}" class="us-nav__btn">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    S'inscrire
                </a>
            @endauth
        </div>

        {{-- Mobile hamburger toggle --}}
        <button
            class="us-nav__mobile-btn"
            @click="mobileOpen = !mobileOpen"
            :aria-expanded="mobileOpen.toString()"
            aria-label="Menu"
        >
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                <path x-show="mobileOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Mobile menu drawer --}}
    <div class="us-nav__mobile" x-show="mobileOpen" x-cloak @click.outside="mobileOpen = false">
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="us-nav__mobile-link">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Tableau de bord
                </a>
                <a href="{{ route('admin.reports.index') }}" class="us-nav__mobile-link">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Signalements
                </a>
                <a href="{{ route('admin.users.index') }}" class="us-nav__mobile-link">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Utilisateurs
                </a>
                <a href="{{ route('admin.categories.index') }}" class="us-nav__mobile-link">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Catégories
                </a>
            @elseif(auth()->user()->isAgent())
                <a href="{{ route('agent.dashboard') }}" class="us-nav__mobile-link">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Tableau de bord
                </a>
                <a href="{{ route('agent.reports.index') }}" class="us-nav__mobile-link">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Signalements
                </a>
                <a href="{{ route('agent.reports.map') }}" class="us-nav__mobile-link">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    Carte
                </a>
            @else
                <a href="{{ route('citizen.dashboard') }}" class="us-nav__mobile-link">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Mes signalements
                </a>
                <a href="{{ route('citizen.reports.create') }}" class="us-nav__mobile-link" style="color:#16a34a; font-weight:600;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Signaler un problème
                </a>
                <a href="{{ route('track') }}" class="us-nav__mobile-link">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    Suivi ticket
                </a>
            @endif

            <div class="us-nav__mobile-sep"></div>

            <a href="{{ route('profile.edit') }}" class="us-nav__mobile-link">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Mon profil ({{ auth()->user()->name }})
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="us-nav__mobile-btn-action us-nav__mobile-btn-action--danger">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Déconnexion
                </button>
            </form>
        @else
            <a href="{{ route('track') }}" class="us-nav__mobile-link">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                Suivi ticket
            </a>
            <a href="{{ route('login') }}" class="us-nav__mobile-link">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                Connexion
            </a>
            <a href="{{ route('register') }}" class="us-nav__mobile-btn-action">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                S'inscrire gratuitement
            </a>
        @endauth
    </div>
</nav>

{{-- ════════════════════════════
     FLASH MESSAGES
════════════════════════════ --}}
@if(session('success'))
    <div class="us-flash">
        <div class="us-alert us-alert--success">
            <svg class="us-alert__icon" width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    </div>
@endif

@if(session('error'))
    <div class="us-flash">
        <div class="us-alert us-alert--error">
            <svg class="us-alert__icon" width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    </div>
@endif

{{-- ════════════════════════════
     MAIN CONTENT
════════════════════════════ --}}
<main class="us-main">
    @yield('content')
</main>

{{-- ════════════════════════════
     FOOTER
════════════════════════════ --}}
<footer class="us-footer">
    <div class="us-footer__top">

        {{-- Brand --}}
        <div>
            <div class="us-footer__brand">
                <div class="us-footer__mark">
                    <img src="{{ asset('images/logo.svg') }}" alt="UrbanSignal Logo">
                </div>
                <span class="us-footer__brand-name">Urban<em>Signal</em></span>
            </div>
            <p class="us-footer__desc">
                Plateforme de signalement de pannes urbaines pour la commune de Ouidah, Bénin.
            </p>
        </div>

        {{-- Navigation links --}}
        <div>
            <span class="us-footer__col-title">Navigation</span>
            <div class="us-footer__links">
                <a href="{{ route('home') }}" class="us-footer__link">Accueil</a>
                <a href="{{ route('track') }}" class="us-footer__link">Suivre un signalement</a>
                @guest
                    <a href="{{ route('register') }}" class="us-footer__link">Créer un compte</a>
                    <a href="{{ route('login') }}" class="us-footer__link">Se connecter</a>
                @endguest
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="us-footer__link">Administration</a>
                    @elseif(auth()->user()->isAgent())
                        <a href="{{ route('agent.dashboard') }}" class="us-footer__link">Espace agent</a>
                    @else
                        <a href="{{ route('citizen.dashboard') }}" class="us-footer__link">Mes signalements</a>
                        <a href="{{ route('citizen.reports.create') }}" class="us-footer__link">Nouveau signalement</a>
                    @endif
                @endauth
            </div>
        </div>

        {{-- Contact --}}
        <div>
            <div class="us-footer__oh-brand">
                <div class="us-footer__oh-mark">
                    <img src="{{ asset('images/mairieOH.jpeg') }}" alt="Mairie de Ouidah">
                </div>
                <span class="us-footer__col-title">Mairie de Ouidah</span>
            </div>

            <div class="us-footer__contact-item">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <a href="https://maps.google.com/?q=Mairie+de+Ouidah+Bénin" target="_blank" rel="noopener noreferrer">
                    Rue de Palmistes, Ouidah, Bénin
                </a>
            </div>
            <div class="us-footer__contact-item">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                +229 22 34 10 91
            </div>
        </div>

    </div>

    <div class="us-footer__bottom">
        <div class="us-footer__bottom-inner">
            <span class="us-footer__copy">
                &copy; {{ date('Y') }} Commune de Ouidah — UrbanSignal. Tous droits réservés.
            </span>
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>