<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs — Super Admin UrbanSignal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600&family=Montserrat:wght@400;500;600;700;900&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    :root {
      --bg: #080E1A; --surface: #0F1829; --card: #141F33;
      --border: rgba(99,179,237,.12); --navy: #1B2F6E; --royal: #2952A3;
      --sky: #5B9BD5; --gold: #E8B84B; --red: #EF4444; --green: #22C55E;
      --smoke: #6B7FA3; --mist: rgba(91,155,213,.06);
      --text: #E2EAF4; --subtext: #6B7FA3; --line: rgba(99,179,237,.1);
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Poppins', sans-serif; background: var(--bg); color: var(--text); -webkit-font-smoothing: antialiased; min-height: 100vh; }
    .sa-shell { display: flex; min-height: 100vh; }

    /* Sidebar (same as dashboard) */
    .sa-sidebar { width: 240px; flex-shrink: 0; background: var(--surface); border-right: 1px solid var(--border); display: flex; flex-direction: column; position: sticky; top: 0; height: 100vh; overflow-y: auto; }
    .sa-sidebar__logo { padding: 1.5rem 1.25rem 1rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: .65rem; }
    .sa-sidebar__mark { width: 34px; height: 34px; border-radius: 9px; background: var(--royal); display: flex; align-items: center; justify-content: center; box-shadow: 0 0 20px rgba(41,82,163,.5); }
    .sa-sidebar__name { font-family: 'Montserrat', sans-serif; font-weight: 800; font-size: .95rem; color: var(--text); }
    .sa-sidebar__name em { font-style: italic; color: var(--sky); }
    .sa-sidebar__role { font-size: .62rem; font-weight: 600; letter-spacing: .12em; text-transform: uppercase; color: var(--gold); padding: .35rem .75rem .1rem 1.25rem; display: block; margin-top: .5rem; }
    .sa-nav { padding: .5rem .75rem 1rem; flex: 1; }
    .sa-nav__item { display: flex; align-items: center; gap: .65rem; padding: .6rem .75rem; border-radius: 9px; font-size: .85rem; font-weight: 500; color: var(--subtext); text-decoration: none; transition: background .15s, color .15s; margin-bottom: .15rem; background: none; border: none; cursor: pointer; width: 100%; text-align: left; }
    .sa-nav__item:hover { background: var(--mist); color: var(--text); }
    .sa-nav__item.active { background: rgba(41,82,163,.25); color: var(--sky); border: 1px solid rgba(91,155,213,.2); }
    .sa-nav__sep { height: 1px; background: var(--border); margin: .5rem 0; }
    .sa-nav__danger { color: rgba(239,68,68,.6) !important; }
    .sa-nav__danger:hover { background: rgba(239,68,68,.08) !important; color: #EF4444 !important; }
    .sa-sidebar__footer { padding: 1rem 1.25rem; border-top: 1px solid var(--border); font-size: .75rem; color: var(--subtext); }
    .sa-sidebar__footer strong { color: var(--text); display: block; margin-bottom: .15rem; }

    /* Main */
    .sa-main { flex: 1; display: flex; flex-direction: column; overflow-x: hidden; }
    .sa-topbar { height: 56px; background: var(--surface); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 2rem; position: sticky; top: 0; z-index: 50; }
    .sa-topbar__title { font-family: 'Montserrat', sans-serif; font-weight: 800; font-size: 1.05rem; color: var(--text); }
    .sa-content { padding: 2rem; flex: 1; }
    .sa-eyebrow { font-size: .68rem; font-weight: 600; letter-spacing: .16em; text-transform: uppercase; color: var(--gold); display: block; margin-bottom: .5rem; }
    .sa-section-title { font-family: 'Montserrat', sans-serif; font-weight: 800; font-size: 1.6rem; color: var(--text); letter-spacing: -.02em; margin-bottom: 1.75rem; }
    .sa-section-title em { font-style: italic; color: var(--sky); }

    /* Flash */
    .sa-flash { margin-bottom: 1.5rem; padding: .85rem 1.1rem; border-radius: 10px; font-size: .88rem; display: flex; align-items: center; gap: .65rem; animation: fadeIn .4s ease; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-6px); } to { opacity: 1; transform: translateY(0); } }
    .sa-flash--success { background: rgba(34,197,94,.08); border: 1px solid rgba(34,197,94,.2); color: #4ADE80; }
    .sa-flash--error   { background: rgba(239,68,68,.08); border: 1px solid rgba(239,68,68,.2); color: #F87171; }

    /* Filters */
    .sa-filters {
      display: flex; flex-wrap: wrap; gap: .75rem;
      margin-bottom: 1.5rem;
      padding: 1rem 1.25rem;
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 14px;
    }
    .sa-filter-input {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 8px;
      padding: .5rem .9rem;
      color: var(--text);
      font-family: 'Poppins', sans-serif; font-size: .85rem;
      outline: none; flex: 1; min-width: 160px;
      transition: border-color .2s;
    }
    .sa-filter-input:focus { border-color: var(--sky); }
    .sa-filter-input::placeholder { color: var(--subtext); }
    .sa-filter-select {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 8px;
      padding: .5rem .9rem;
      color: var(--text);
      font-family: 'Poppins', sans-serif; font-size: .85rem;
      outline: none; cursor: pointer;
    }
    .sa-filter-btn {
      background: var(--royal); color: #fff;
      font-family: 'Poppins', sans-serif; font-weight: 600; font-size: .82rem;
      padding: .5rem 1.1rem; border-radius: 8px; border: none; cursor: pointer;
      transition: background .18s;
    }
    .sa-filter-btn:hover { background: #3562C0; }

    /* Table */
    .sa-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; }
    .sa-card__head { padding: 1rem 1.25rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
    .sa-card__title { font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: .95rem; color: var(--text); display: flex; align-items: center; gap: .5rem; }
    .sa-table-wrap { overflow-x: auto; }
    table.sa-table { width: 100%; border-collapse: collapse; }
    .sa-table thead { background: rgba(91,155,213,.05); }
    .sa-table th { padding: .7rem 1.1rem; text-align: left; font-size: .62rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--subtext); white-space: nowrap; }
    .sa-table tbody tr { border-bottom: 1px solid var(--line); transition: background .15s; }
    .sa-table tbody tr:last-child { border-bottom: none; }
    .sa-table tbody tr:hover { background: var(--mist); }
    .sa-table td { padding: .75rem 1.1rem; vertical-align: middle; }
    .sa-user-name { font-size: .85rem; font-weight: 600; color: var(--text); }
    .sa-user-email { font-size: .75rem; color: var(--subtext); font-weight: 300; margin-top: .1rem; }
    .sa-role-badge { display: inline-flex; padding: .2rem .6rem; border-radius: 5px; font-size: .65rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; }
    .sa-role-badge--admin   { background: rgba(41,82,163,.2); color: var(--sky); border: 1px solid rgba(91,155,213,.2); }
    .sa-role-badge--agent   { background: rgba(232,184,75,.1); color: var(--gold); border: 1px solid rgba(232,184,75,.2); }
    .sa-role-badge--citizen { background: rgba(34,197,94,.08); color: #4ADE80; border: 1px solid rgba(34,197,94,.15); }
    .sa-date { font-size: .72rem; color: var(--subtext); font-family: 'JetBrains Mono', monospace; }

    .sa-btn { display: inline-flex; align-items: center; gap: .35rem; font-family: 'Poppins', sans-serif; font-weight: 600; font-size: .75rem; padding: .38rem .75rem; border-radius: 7px; border: none; cursor: pointer; text-decoration: none; transition: all .18s; white-space: nowrap; }
    .sa-btn--ghost { background: rgba(91,155,213,.1); border: 1px solid rgba(91,155,213,.2); color: var(--sky); }
    .sa-btn--ghost:hover { background: rgba(91,155,213,.18); }
    .sa-btn--warn  { background: rgba(232,184,75,.1); border: 1px solid rgba(232,184,75,.2); color: var(--gold); }
    .sa-btn--warn:hover  { background: rgba(232,184,75,.18); }
    .sa-btn--danger { background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.2); color: #F87171; }
    .sa-btn--danger:hover { background: rgba(239,68,68,.2); }

    .sa-actions-cell { display: flex; gap: .4rem; align-items: center; flex-wrap: wrap; }

    /* Status banned */
    .sa-banned { opacity: .45; }

    .sa-pagination { padding: 1rem 1.25rem; border-top: 1px solid var(--border); }
    </style>
</head>
<body>
<div class="sa-shell">

    {{-- Sidebar --}}
    <aside class="sa-sidebar">
        <div class="sa-sidebar__logo">
            <div class="sa-sidebar__mark">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24"><path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <span class="sa-sidebar__name">Urban<em>Signal</em></span>
                <span style="font-size:.6rem;color:var(--subtext);display:block">Ouidah</span>
            </div>
        </div>
        <span class="sa-sidebar__role">⚡ Super Admin</span>
        <nav class="sa-nav">
            <a href="{{ route('superadmin.dashboard') }}" class="sa-nav__item">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('superadmin.users') }}" class="sa-nav__item active">
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
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sa-nav__item sa-nav__danger">
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

    {{-- Main --}}
    <div class="sa-main">
        <header class="sa-topbar">
            <span class="sa-topbar__title">Gestion des utilisateurs</span>
        </header>

        <div class="sa-content">

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

            <span class="sa-eyebrow">Gestion</span>
            <h1 class="sa-section-title">Tous les <em>utilisateurs</em></h1>

            {{-- Filters --}}
            <form method="GET" action="{{ route('superadmin.users') }}" class="sa-filters">
                <input type="text" name="search" class="sa-filter-input"
                       placeholder="Rechercher par nom ou email..."
                       value="{{ request('search') }}">
                <select name="role" class="sa-filter-select">
                    <option value="">Tous les rôles</option>
                    <option value="admin"   {{ request('role') === 'admin'   ? 'selected' : '' }}>Admins</option>
                    <option value="agent"   {{ request('role') === 'agent'   ? 'selected' : '' }}>Agents</option>
                    <option value="citizen" {{ request('role') === 'citizen' ? 'selected' : '' }}>Citoyens</option>
                </select>
                <button type="submit" class="sa-filter-btn">Filtrer</button>
                <a href="{{ route('superadmin.users') }}" class="sa-filter-btn" style="background: var(--surface); border: 1px solid var(--border); color: var(--subtext); text-decoration:none; display:inline-flex; align-items:center; padding:.5rem 1rem; border-radius:8px; font-size:.82rem;">Réinitialiser</a>
            </form>

            {{-- Table --}}
            <div class="sa-card">
                <div class="sa-card__head">
                    <span class="sa-card__title">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $users->total() }} utilisateur{{ $users->total() > 1 ? 's' : '' }}
                    </span>
                </div>
                <div class="sa-table-wrap">
                    <table class="sa-table">
                        <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Téléphone</th>
                                <th>Rôle</th>
                                <th>Statut</th>
                                <th>Inscrit le</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="{{ $user->email_verified_at ? '' : 'sa-banned' }}">
                                <td>
                                    <div class="sa-user-name">{{ $user->name }}</div>
                                    <div class="sa-user-email">{{ $user->email }}</div>
                                </td>
                                <td><span class="sa-date">{{ $user->phone ?? '—' }}</span></td>
                                <td>
                                    <span class="sa-role-badge sa-role-badge--{{ $user->role }}">{{ $user->role }}</span>
                                </td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span style="font-size:.72rem;color:var(--green)">● Actif</span>
                                    @else
                                        <span style="font-size:.72rem;color:var(--red)">● Suspendu</span>
                                    @endif
                                </td>
                                <td><span class="sa-date">{{ $user->created_at->format('d/m/Y') }}</span></td>
                                <td>
                                    <div class="sa-actions-cell">
                                        {{-- Changer le rôle --}}
                                        <form method="POST" action="{{ route('superadmin.users.promote', $user) }}" style="display:flex;gap:.3rem;align-items:center">
                                            @csrf @method('PATCH')
                                            <select name="role" style="background:var(--surface);border:1px solid var(--border);color:var(--text);font-size:.72rem;padding:.3rem .5rem;border-radius:6px;outline:none;cursor:pointer">
                                                <option value="citizen" {{ $user->role === 'citizen' ? 'selected' : '' }}>Citoyen</option>
                                                <option value="agent"   {{ $user->role === 'agent'   ? 'selected' : '' }}>Agent</option>
                                                <option value="admin"   {{ $user->role === 'admin'   ? 'selected' : '' }}>Admin</option>
                                            </select>
                                            <button type="submit" class="sa-btn sa-btn--ghost">↑</button>
                                        </form>

                                        {{-- Reset mot de passe --}}
                                        <form method="POST" action="{{ route('superadmin.users.reset-password', $user) }}">
                                            @csrf
                                            <button type="submit" class="sa-btn sa-btn--warn"
                                                    onclick="return confirm('Générer un nouveau mot de passe pour {{ $user->name }} ?')">
                                                🔑
                                            </button>
                                        </form>

                                        {{-- Suspendre / Réactiver --}}
                                        <form method="POST" action="{{ route('superadmin.users.ban', $user) }}">
                                            @csrf
                                            <button type="submit" class="sa-btn {{ $user->email_verified_at ? 'sa-btn--danger' : 'sa-btn--ghost' }}"
                                                    onclick="return confirm('{{ $user->email_verified_at ? 'Suspendre' : 'Réactiver' }} {{ $user->name }} ?')">
                                                {{ $user->email_verified_at ? '🚫' : '✓' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($users->hasPages())
                <div class="sa-pagination" style="color:var(--subtext);font-size:.82rem">
                    {{ $users->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
</body>
</html>