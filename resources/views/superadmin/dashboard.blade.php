<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin — UrbanSignal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600&family=Montserrat:wght@400;500;600;700;900&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    /* ── Tokens ── */
    :root {
      --bg:      #080E1A;
      --surface: #0F1829;
      --card:    #141F33;
      --border:  rgba(99,179,237,.12);
      --navy:    #1B2F6E;
      --royal:   #2952A3;
      --sky:     #5B9BD5;
      --gold:    #E8B84B;
      --red:     #EF4444;
      --green:   #22C55E;
      --smoke:   #6B7FA3;
      --mist:    rgba(91,155,213,.06);
      --text:    #E2EAF4;
      --subtext: #6B7FA3;
      --line:    rgba(99,179,237,.1);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--bg);
      color: var(--text);
      -webkit-font-smoothing: antialiased;
      min-height: 100vh;
    }

    /* ── Layout shell ── */
    .sa-shell { display: flex; min-height: 100vh; }

    /* ══════════════════════════════
       SIDEBAR
    ══════════════════════════════ */
    .sa-sidebar {
      width: 240px; flex-shrink: 0;
      background: var(--surface);
      border-right: 1px solid var(--border);
      display: flex; flex-direction: column;
      position: sticky; top: 0; height: 100vh;
      overflow-y: auto;
    }

    .sa-sidebar__logo {
      padding: 1.5rem 1.25rem 1rem;
      border-bottom: 1px solid var(--border);
      display: flex; align-items: center; gap: .65rem;
    }

    .sa-sidebar__mark {
      width: 34px; height: 34px; border-radius: 9px;
      background: var(--royal);
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 0 20px rgba(41,82,163,.5);
    }

    .sa-sidebar__name {
      font-family: 'Montserrat', sans-serif;
      font-weight: 800; font-size: .95rem; color: var(--text);
    }
    .sa-sidebar__name em { font-style: italic; color: var(--sky); }

    .sa-sidebar__role {
      font-size: .62rem; font-weight: 600;
      letter-spacing: .12em; text-transform: uppercase;
      color: var(--gold);
      padding: .35rem .75rem .1rem 1.25rem;
      display: block; margin-top: .5rem;
    }

    .sa-nav { padding: .5rem .75rem 1rem; flex: 1; }

    .sa-nav__item {
      display: flex; align-items: center; gap: .65rem;
      padding: .6rem .75rem;
      border-radius: 9px;
      font-size: .85rem; font-weight: 500;
      color: var(--subtext); text-decoration: none;
      transition: background .15s, color .15s;
      margin-bottom: .15rem;
    }
    .sa-nav__item:hover { background: var(--mist); color: var(--text); }
    .sa-nav__item.active {
      background: rgba(41,82,163,.25);
      color: var(--sky);
      border: 1px solid rgba(91,155,213,.2);
    }
    .sa-nav__item svg { flex-shrink: 0; opacity: .7; }
    .sa-nav__item.active svg { opacity: 1; }

    .sa-nav__sep {
      height: 1px; background: var(--border);
      margin: .5rem 0;
    }

    .sa-nav__danger {
      color: rgba(239,68,68,.6) !important;
    }
    .sa-nav__danger:hover {
      background: rgba(239,68,68,.08) !important;
      color: #EF4444 !important;
    }

    .sa-sidebar__footer {
      padding: 1rem 1.25rem;
      border-top: 1px solid var(--border);
      font-size: .75rem; color: var(--subtext);
    }
    .sa-sidebar__footer strong { color: var(--text); display: block; margin-bottom: .15rem; }

    /* ══════════════════════════════
       MAIN
    ══════════════════════════════ */
    .sa-main {
      flex: 1; display: flex; flex-direction: column;
      overflow-x: hidden;
    }

    /* Topbar */
    .sa-topbar {
      height: 56px;
      background: var(--surface);
      border-bottom: 1px solid var(--border);
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 2rem;
      position: sticky; top: 0; z-index: 50;
    }

    .sa-topbar__title {
      font-family: 'Montserrat', sans-serif;
      font-weight: 800; font-size: 1.05rem; color: var(--text);
    }

    .sa-topbar__right {
      display: flex; align-items: center; gap: 1rem;
    }

    .sa-status-pill {
      display: inline-flex; align-items: center; gap: .4rem;
      padding: .3rem .75rem; border-radius: 999px;
      font-size: .72rem; font-weight: 600;
      letter-spacing: .06em;
    }
    .sa-status-pill--online {
      background: rgba(34,197,94,.1);
      border: 1px solid rgba(34,197,94,.25);
      color: #22C55E;
    }
    .sa-status-pill--maintenance {
      background: rgba(239,68,68,.1);
      border: 1px solid rgba(239,68,68,.25);
      color: #EF4444;
    }
    .sa-status-pill__dot {
      width: 6px; height: 6px; border-radius: 50%;
      background: currentColor;
      animation: pulse 2s ease-in-out infinite;
    }
    @keyframes pulse {
      0%,100% { opacity: 1; } 50% { opacity: .4; }
    }

    .sa-topbar__logout {
      font-size: .8rem; color: var(--subtext);
      text-decoration: none; transition: color .18s;
    }
    .sa-topbar__logout:hover { color: #EF4444; }

    /* Content area */
    .sa-content {
      padding: 2rem;
      flex: 1;
    }

    /* Flash */
    .sa-flash {
      margin-bottom: 1.5rem;
      padding: .85rem 1.1rem;
      border-radius: 10px;
      font-size: .88rem;
      display: flex; align-items: center; gap: .65rem;
      animation: fadeIn .4s ease;
    }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-6px); } to { opacity: 1; transform: translateY(0); } }
    .sa-flash--success { background: rgba(34,197,94,.08); border: 1px solid rgba(34,197,94,.2); color: #4ADE80; }
    .sa-flash--error   { background: rgba(239,68,68,.08); border: 1px solid rgba(239,68,68,.2); color: #F87171; }

    /* Section eyebrow */
    .sa-eyebrow {
      font-size: .68rem; font-weight: 600;
      letter-spacing: .16em; text-transform: uppercase;
      color: var(--gold); display: block; margin-bottom: .5rem;
    }

    .sa-section-title {
      font-family: 'Montserrat', sans-serif;
      font-weight: 800; font-size: 1.6rem;
      color: var(--text); letter-spacing: -.02em;
      margin-bottom: 1.75rem;
    }
    .sa-section-title em { font-style: italic; color: var(--sky); }

    /* ── KPI grid ── */
    .sa-kpis {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1px;
      background: var(--border);
      border: 1px solid var(--border);
      border-radius: 16px;
      overflow: hidden;
      margin-bottom: 1.75rem;
    }
    @media(min-width:900px){ .sa-kpis { grid-template-columns: repeat(4,1fr); } }

    .sa-kpi {
      background: var(--card);
      padding: 1.35rem 1.25rem;
      position: relative;
      transition: background .2s;
    }
    .sa-kpi:hover { background: #182338; }
    .sa-kpi::before {
      content: '';
      position: absolute; left: 0; top: 22%; bottom: 22%;
      width: 2px; border-radius: 0 2px 2px 0;
      background: var(--c, var(--smoke));
    }

    .sa-kpi__num {
      font-family: 'JetBrains Mono', monospace;
      font-weight: 600; font-size: 2rem;
      line-height: 1; color: var(--text);
      margin-bottom: .3rem; letter-spacing: -.04em;
    }
    .sa-kpi__label {
      font-size: .67rem; font-weight: 600;
      letter-spacing: .1em; text-transform: uppercase;
      color: var(--subtext);
    }

    /* ── 2 col grid ── */
    .sa-grid-2 {
      display: grid; grid-template-columns: 1fr;
      gap: 1.5rem; margin-bottom: 1.5rem;
    }
    @media(min-width:1024px){ .sa-grid-2 { grid-template-columns: 1fr 1fr; } }

    /* ── Card ── */
    .sa-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 16px;
      overflow: hidden;
    }

    .sa-card__head {
      padding: 1rem 1.25rem;
      border-bottom: 1px solid var(--border);
      display: flex; align-items: center; justify-content: space-between;
    }

    .sa-card__title {
      font-family: 'Montserrat', sans-serif;
      font-weight: 700; font-size: .95rem; color: var(--text);
      display: flex; align-items: center; gap: .5rem;
    }

    .sa-card__action {
      font-size: .75rem; font-weight: 600;
      color: var(--sky); text-decoration: none;
      transition: color .18s;
    }
    .sa-card__action:hover { color: var(--text); }

    /* ── System info table ── */
    .sa-sys-table { width: 100%; border-collapse: collapse; }
    .sa-sys-table tr { border-bottom: 1px solid var(--line); }
    .sa-sys-table tr:last-child { border-bottom: none; }
    .sa-sys-table td {
      padding: .7rem 1.25rem;
      font-size: .82rem;
    }
    .sa-sys-table td:first-child { color: var(--subtext); width: 45%; }
    .sa-sys-table td:last-child  {
      color: var(--text); font-weight: 500;
      font-family: 'JetBrains Mono', monospace; font-size: .78rem;
    }

    /* ── Users table ── */
    .sa-table-wrap { overflow-x: auto; }
    table.sa-table { width: 100%; border-collapse: collapse; }
    .sa-table thead { background: rgba(91,155,213,.05); }
    .sa-table th {
      padding: .7rem 1.1rem; text-align: left;
      font-size: .62rem; font-weight: 700;
      letter-spacing: .12em; text-transform: uppercase;
      color: var(--subtext); white-space: nowrap;
    }
    .sa-table tbody tr {
      border-bottom: 1px solid var(--line);
      transition: background .15s;
    }
    .sa-table tbody tr:last-child { border-bottom: none; }
    .sa-table tbody tr:hover { background: var(--mist); }
    .sa-table td { padding: .75rem 1.1rem; vertical-align: middle; }

    .sa-user-name { font-size: .85rem; font-weight: 600; color: var(--text); }
    .sa-user-email { font-size: .75rem; color: var(--subtext); font-weight: 300; margin-top: .1rem; }

    .sa-role-badge {
      display: inline-flex; padding: .2rem .6rem;
      border-radius: 5px; font-size: .65rem; font-weight: 700;
      letter-spacing: .06em; text-transform: uppercase;
    }
    .sa-role-badge--admin   { background: rgba(41,82,163,.2); color: var(--sky); border: 1px solid rgba(91,155,213,.2); }
    .sa-role-badge--agent   { background: rgba(232,184,75,.1); color: var(--gold); border: 1px solid rgba(232,184,75,.2); }
    .sa-role-badge--citizen { background: rgba(34,197,94,.08); color: #4ADE80; border: 1px solid rgba(34,197,94,.15); }

    .sa-date { font-size: .75rem; color: var(--subtext); font-family: 'JetBrains Mono', monospace; }

    /* ── Log terminal ── */
    .sa-log {
      background: #050A12;
      border-top: 1px solid var(--border);
      padding: 1rem 1.25rem;
      max-height: 220px; overflow-y: auto;
      font-family: 'JetBrains Mono', monospace;
      font-size: .72rem; line-height: 1.65;
    }
    .sa-log-line { color: #4A9ECC; margin-bottom: .1rem; word-break: break-all; }
    .sa-log-line--error { color: #F87171; }
    .sa-log-line--warn  { color: var(--gold); }

    /* ── Action buttons ── */
    .sa-btn {
      display: inline-flex; align-items: center; gap: .4rem;
      font-family: 'Poppins', sans-serif;
      font-weight: 600; font-size: .78rem;
      padding: .45rem .9rem; border-radius: 8px;
      border: none; cursor: pointer; text-decoration: none;
      transition: all .18s; white-space: nowrap;
    }
    .sa-btn--primary {
      background: var(--royal); color: #fff;
      box-shadow: 0 2px 12px rgba(41,82,163,.3);
    }
    .sa-btn--primary:hover { background: #3562C0; transform: translateY(-1px); }
    .sa-btn--ghost {
      background: rgba(91,155,213,.1);
      border: 1px solid rgba(91,155,213,.2);
      color: var(--sky);
    }
    .sa-btn--ghost:hover { background: rgba(91,155,213,.18); }
    .sa-btn--danger {
      background: rgba(239,68,68,.1);
      border: 1px solid rgba(239,68,68,.2);
      color: #F87171;
    }
    .sa-btn--danger:hover { background: rgba(239,68,68,.2); }

    /* entrance */
    @keyframes sa-up {
      from { opacity: 0; transform: translateY(14px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .sa-content > * {
      animation: sa-up .5s cubic-bezier(.22,1,.36,1) both;
    }
    .sa-content > *:nth-child(1){ animation-delay: .04s; }
    .sa-content > *:nth-child(2){ animation-delay: .10s; }
    .sa-content > *:nth-child(3){ animation-delay: .16s; }
    .sa-content > *:nth-child(4){ animation-delay: .22s; }
    .sa-content > *:nth-child(5){ animation-delay: .28s; }
    </style>
</head>
<body>

<div class="sa-shell">

    {{-- ══ SIDEBAR ══ --}}
    <aside class="sa-sidebar">
        <div class="sa-sidebar__logo">
            <div class="sa-sidebar__mark">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                    <path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <span class="sa-sidebar__name">Urban<em>Signal</em></span>
                <span style="font-size:.6rem;color:var(--subtext);display:block">Ouidah</span>
            </div>
        </div>

        <span class="sa-sidebar__role">⚡ Super Admin</span>

        <nav class="sa-nav">
            <a href="{{ route('superadmin.dashboard') }}" class="sa-nav__item active">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('superadmin.users') }}" class="sa-nav__item">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Utilisateurs
            </a>
            <a href="{{ route('superadmin.maintenance') }}" class="sa-nav__item">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Maintenance & Logs
            </a>
            <a href="{{ route('superadmin.settings') }}" class="sa-nav__item">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                Paramètres
            </a>

            <div class="sa-nav__sep"></div>

            <a href="{{ route('superadmin.export.users') }}" class="sa-nav__item">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export Utilisateurs
            </a>
            <a href="{{ route('superadmin.export.reports') }}" class="sa-nav__item">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export Signalements
            </a>

            <div class="sa-nav__sep"></div>

            <a href="{{ route('admin.dashboard') }}" class="sa-nav__item">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Vue Admin
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sa-nav__item sa-nav__danger" style="width:100%;background:none;border:none;cursor:pointer;text-align:left">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Déconnexion
                </button>
            </form>
        </nav>

        <div class="sa-sidebar__footer">
            <strong>{{ auth()->user()->name }}</strong>
            {{ auth()->user()->email }}
        </div>
    </aside>

    {{-- ══ MAIN ══ --}}
    <div class="sa-main">

        {{-- Topbar --}}
        <header class="sa-topbar">
            <span class="sa-topbar__title">Dashboard</span>
            <div class="sa-topbar__right">
                @if(app()->isDownForMaintenance())
                    <span class="sa-status-pill sa-status-pill--maintenance">
                        <span class="sa-status-pill__dot"></span>
                        Maintenance
                    </span>
                @else
                    <span class="sa-status-pill sa-status-pill--online">
                        <span class="sa-status-pill__dot"></span>
                        En ligne
                    </span>
                @endif
                <span style="font-size:.75rem;color:var(--subtext);font-family:'JetBrains Mono',monospace">
                    {{ now()->format('d/m/Y H:i') }}
                </span>
            </div>
        </header>

        <div class="sa-content">

            {{-- Flash --}}
            @if(session('success'))
                <div class="sa-flash sa-flash--success">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="sa-flash sa-flash--error">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Header --}}
            <div style="margin-bottom:1.75rem">
                <span class="sa-eyebrow">UrbanSignal — Ouidah</span>
                <h1 class="sa-section-title">Vue d'ensemble <em>Super Admin</em></h1>
            </div>

            {{-- KPIs --}}
            <div class="sa-kpis">
                <div class="sa-kpi" style="--c: var(--sky)">
                    <div class="sa-kpi__num">{{ $stats['total_users'] }}</div>
                    <div class="sa-kpi__label">Utilisateurs</div>
                </div>
                <div class="sa-kpi" style="--c: var(--royal)">
                    <div class="sa-kpi__num" style="color: var(--sky)">{{ $stats['total_reports'] }}</div>
                    <div class="sa-kpi__label">Signalements</div>
                </div>
                <div class="sa-kpi" style="--c: var(--gold)">
                    <div class="sa-kpi__num" style="color: var(--gold)">{{ $stats['reports_today'] }}</div>
                    <div class="sa-kpi__label">Aujourd'hui</div>
                </div>
                <div class="sa-kpi" style="--c: var(--red)">
                    <div class="sa-kpi__num" style="color: var(--red)">{{ $stats['pending'] }}</div>
                    <div class="sa-kpi__label">En attente</div>
                </div>
                <div class="sa-kpi" style="--c: var(--green)">
                    <div class="sa-kpi__num" style="color: var(--green)">{{ $stats['resolved'] }}</div>
                    <div class="sa-kpi__label">Résolus</div>
                </div>
                <div class="sa-kpi" style="--c: var(--gold)">
                    <div class="sa-kpi__num" style="color: var(--gold)">{{ $stats['total_admins'] }}</div>
                    <div class="sa-kpi__label">Admins</div>
                </div>
                <div class="sa-kpi" style="--c: var(--sky)">
                    <div class="sa-kpi__num" style="color: var(--sky)">{{ $stats['total_agents'] }}</div>
                    <div class="sa-kpi__label">Agents</div>
                </div>
                <div class="sa-kpi" style="--c: var(--green)">
                    <div class="sa-kpi__num" style="color: var(--green)">{{ $stats['total_citizens'] }}</div>
                    <div class="sa-kpi__label">Citoyens</div>
                </div>
            </div>

            {{-- Grid: Système + Utilisateurs récents --}}
            <div class="sa-grid-2">

                {{-- Infos système --}}
                <div class="sa-card">
                    <div class="sa-card__head">
                        <span class="sa-card__title">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
                            Environnement système
                        </span>
                        <a href="{{ route('superadmin.maintenance') }}" class="sa-card__action">Maintenance →</a>
                    </div>
                    <table class="sa-sys-table">
                        @foreach($systemInfo as $key => $value)
                        <tr>
                            <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                            <td>
                                @if(str_contains(strtolower($value), 'activé') || str_contains($value, '⚠️'))
                                    <span style="color: var(--gold)">{{ $value }}</span>
                                @elseif(str_contains(strtolower($value), 'désactivé') || str_contains($value, '✓') || str_contains(strtolower($value), 'ligne'))
                                    <span style="color: var(--green)">{{ $value }}</span>
                                @elseif(str_contains(strtolower($value), 'maintenance'))
                                    <span style="color: var(--red)">{{ $value }}</span>
                                @else
                                    {{ $value }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>

                    {{-- Cache actions --}}
                    <div style="padding: 1rem 1.25rem; border-top: 1px solid var(--border); display:flex; gap:.6rem; flex-wrap:wrap;">
                        <form method="POST" action="{{ route('superadmin.cache.clear') }}">
                            @csrf
                            <input type="hidden" name="type" value="all">
                            <button type="submit" class="sa-btn sa-btn--ghost">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                Vider tout le cache
                            </button>
                        </form>
                        <form method="POST" action="{{ route('superadmin.cache.clear') }}">
                            @csrf
                            <input type="hidden" name="type" value="config">
                            <button type="submit" class="sa-btn sa-btn--ghost">Config</button>
                        </form>
                        <form method="POST" action="{{ route('superadmin.cache.clear') }}">
                            @csrf
                            <input type="hidden" name="type" value="view">
                            <button type="submit" class="sa-btn sa-btn--ghost">Vues</button>
                        </form>
                        <form method="POST" action="{{ route('superadmin.cache.clear') }}">
                            @csrf
                            <input type="hidden" name="type" value="route">
                            <button type="submit" class="sa-btn sa-btn--ghost">Routes</button>
                        </form>
                    </div>
                </div>

                {{-- Utilisateurs récents --}}
                <div class="sa-card">
                    <div class="sa-card__head">
                        <span class="sa-card__title">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            Derniers inscrits
                        </span>
                        <a href="{{ route('superadmin.users') }}" class="sa-card__action">Voir tous →</a>
                    </div>
                    <div class="sa-table-wrap">
                        <table class="sa-table">
                            <thead>
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Rôle</th>
                                    <th>Inscrit le</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentUsers as $user)
                                <tr>
                                    <td>
                                        <div class="sa-user-name">{{ $user->name }}</div>
                                        <div class="sa-user-email">{{ $user->email }}</div>
                                    </td>
                                    <td>
                                        <span class="sa-role-badge sa-role-badge--{{ $user->role }}">{{ $user->role }}</span>
                                    </td>
                                    <td>
                                        <span class="sa-date">{{ $user->created_at->format('d/m/y') }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- Logs --}}
            <div class="sa-card">
                <div class="sa-card__head">
                    <span class="sa-card__title">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Logs Laravel récents
                    </span>
                    <a href="{{ route('superadmin.maintenance') }}" class="sa-card__action">Logs complets →</a>
                </div>
                <div class="sa-log" id="log-terminal">
                    @forelse($logLines as $line)
                        @php
                            $class = 'sa-log-line';
                            if (str_contains($line, 'ERROR') || str_contains($line, 'CRITICAL')) $class .= ' sa-log-line--error';
                            elseif (str_contains($line, 'WARNING') || str_contains($line, 'SUPERADMIN')) $class .= ' sa-log-line--warn';
                        @endphp
                        <div class="{{ $class }}">{{ $line }}</div>
                    @empty
                        <div class="sa-log-line" style="color: var(--subtext)">// Aucun log disponible</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

</div>

<script>
// Auto-scroll log terminal to bottom
const logEl = document.getElementById('log-terminal');
if (logEl) logEl.scrollTop = logEl.scrollHeight;
</script>

</body>
</html>