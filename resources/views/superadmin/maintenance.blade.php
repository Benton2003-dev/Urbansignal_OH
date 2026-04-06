{{--
=================================================================
  superadmin/maintenance.blade.php
=================================================================
--}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance — Super Admin UrbanSignal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600&family=Montserrat:wght@400;500;600;700;900&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    :root { --bg:#080E1A;--surface:#0F1829;--card:#141F33;--border:rgba(99,179,237,.12);--royal:#2952A3;--sky:#5B9BD5;--gold:#E8B84B;--red:#EF4444;--green:#22C55E;--smoke:#6B7FA3;--mist:rgba(91,155,213,.06);--text:#E2EAF4;--subtext:#6B7FA3;--line:rgba(99,179,237,.1); }
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Outfit',sans-serif;background:var(--bg);color:var(--text);-webkit-font-smoothing:antialiased;min-height:100vh}
    .sa-shell{display:flex;min-height:100vh}
    .sa-sidebar{width:240px;flex-shrink:0;background:var(--surface);border-right:1px solid var(--border);display:flex;flex-direction:column;position:sticky;top:0;height:100vh;overflow-y:auto}
    .sa-sidebar__logo{padding:1.5rem 1.25rem 1rem;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:.65rem}
    .sa-sidebar__mark{width:34px;height:34px;border-radius:9px;background:var(--royal);display:flex;align-items:center;justify-content:center}
    .sa-sidebar__name{font-family:'Syne',sans-serif;font-weight:800;font-size:.95rem;color:var(--text)}
    .sa-sidebar__name em{font-style:italic;color:var(--sky)}
    .sa-sidebar__role{font-size:.62rem;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:var(--gold);padding:.35rem .75rem .1rem 1.25rem;display:block;margin-top:.5rem}
    .sa-nav{padding:.5rem .75rem 1rem;flex:1}
    .sa-nav__item{display:flex;align-items:center;gap:.65rem;padding:.6rem .75rem;border-radius:9px;font-size:.85rem;font-weight:500;color:var(--subtext);text-decoration:none;transition:background .15s,color .15s;margin-bottom:.15rem;background:none;border:none;cursor:pointer;width:100%;text-align:left}
    .sa-nav__item:hover{background:var(--mist);color:var(--text)}
    .sa-nav__item.active{background:rgba(41,82,163,.25);color:var(--sky);border:1px solid rgba(91,155,213,.2)}
    .sa-nav__sep{height:1px;background:var(--border);margin:.5rem 0}
    .sa-nav__danger{color:rgba(239,68,68,.6)!important}
    .sa-nav__danger:hover{background:rgba(239,68,68,.08)!important;color:#EF4444!important}
    .sa-sidebar__footer{padding:1rem 1.25rem;border-top:1px solid var(--border);font-size:.75rem;color:var(--subtext)}
    .sa-sidebar__footer strong{color:var(--text);display:block;margin-bottom:.15rem}
    .sa-main{flex:1;display:flex;flex-direction:column;overflow-x:hidden}
    .sa-topbar{height:56px;background:var(--surface);border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;padding:0 2rem;position:sticky;top:0;z-index:50}
    .sa-topbar__title{font-family:'Syne',sans-serif;font-weight:800;font-size:1.05rem;color:var(--text)}
    .sa-content{padding:2rem;flex:1}
    .sa-eyebrow{font-size:.68rem;font-weight:600;letter-spacing:.16em;text-transform:uppercase;color:var(--gold);display:block;margin-bottom:.5rem}
    .sa-section-title{font-family:'Syne',sans-serif;font-weight:800;font-size:1.6rem;color:var(--text);letter-spacing:-.02em;margin-bottom:1.75rem}
    .sa-section-title em{font-style:italic;color:var(--sky)}
    .sa-flash{margin-bottom:1.5rem;padding:.85rem 1.1rem;border-radius:10px;font-size:.88rem;display:flex;align-items:center;gap:.65rem}
    .sa-flash--success{background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.2);color:#4ADE80}
    .sa-flash--error{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);color:#F87171}
    .sa-card{background:var(--card);border:1px solid var(--border);border-radius:16px;overflow:hidden;margin-bottom:1.5rem}
    .sa-card__head{padding:1rem 1.25rem;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}
    .sa-card__title{font-family:'Syne',sans-serif;font-weight:700;font-size:.95rem;color:var(--text);display:flex;align-items:center;gap:.5rem}
    .sa-card__body{padding:1.5rem}
    .sa-grid-2{display:grid;grid-template-columns:1fr;gap:1.5rem;margin-bottom:1.5rem}
    @media(min-width:900px){.sa-grid-2{grid-template-columns:1fr 1fr}}
    .sa-btn{display:inline-flex;align-items:center;gap:.4rem;font-family:'Outfit',sans-serif;font-weight:600;font-size:.82rem;padding:.55rem 1.1rem;border-radius:9px;border:none;cursor:pointer;text-decoration:none;transition:all .18s;white-space:nowrap}
    .sa-btn--danger{background:rgba(239,68,68,.12);border:1px solid rgba(239,68,68,.25);color:#F87171}
    .sa-btn--danger:hover{background:rgba(239,68,68,.22)}
    .sa-btn--success{background:rgba(34,197,94,.12);border:1px solid rgba(34,197,94,.25);color:#4ADE80}
    .sa-btn--success:hover{background:rgba(34,197,94,.22)}
    .sa-btn--ghost{background:rgba(91,155,213,.1);border:1px solid rgba(91,155,213,.2);color:var(--sky)}
    .sa-btn--ghost:hover{background:rgba(91,155,213,.18)}
    .sa-log{background:#050A12;padding:1rem 1.25rem;max-height:400px;overflow-y:auto;font-family:'JetBrains Mono',monospace;font-size:.72rem;line-height:1.65}
    .sa-log-line{color:#4A9ECC;margin-bottom:.1rem;word-break:break-all}
    .sa-log-line--error{color:#F87171}
    .sa-log-line--warn{color:var(--gold)}
    .sa-maintenance-status{display:flex;align-items:center;gap:1.5rem;padding:1.5rem;flex-wrap:wrap}
    .sa-status-big{display:inline-flex;align-items:center;gap:.6rem;padding:.5rem 1.2rem;border-radius:999px;font-weight:700;font-size:.9rem}
    .sa-status-big--online{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.25);color:#4ADE80}
    .sa-status-big--down{background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);color:#F87171}
    .sa-cache-btns{display:flex;gap:.6rem;flex-wrap:wrap;padding:1rem 1.25rem;border-top:1px solid var(--border)}
    </style>
</head>
<body>
<div class="sa-shell">
    <aside class="sa-sidebar">
        <div class="sa-sidebar__logo">
            <div class="sa-sidebar__mark">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24"><path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div><span class="sa-sidebar__name">Urban<em>Signal</em></span><span style="font-size:.6rem;color:var(--subtext);display:block">Ouidah</span></div>
        </div>
        <span class="sa-sidebar__role">⚡ Super Admin</span>
        <nav class="sa-nav">
            <a href="{{ route('superadmin.dashboard') }}" class="sa-nav__item"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>Dashboard</a>
            <a href="{{ route('superadmin.users') }}" class="sa-nav__item"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>Utilisateurs</a>
            <a href="{{ route('superadmin.maintenance') }}" class="sa-nav__item active"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>Maintenance & Logs</a>
            <a href="{{ route('superadmin.settings') }}" class="sa-nav__item"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>Paramètres</a>
            <div class="sa-nav__sep"></div>
            <form method="POST" action="{{ route('logout') }}"><@csrf<button type="submit" class="sa-nav__item sa-nav__danger"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>Déconnexion</button></form>
        </nav>
        <div class="sa-sidebar__footer"><strong>{{ auth()->user()->name }}</strong>{{ auth()->user()->email }}</div>
    </aside>

    <div class="sa-main">
        <header class="sa-topbar"><span class="sa-topbar__title">Maintenance & Logs</span></header>
        <div class="sa-content">

            @if(session('success'))<div class="sa-flash sa-flash--success">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="sa-flash sa-flash--error">{{ session('error') }}</div>@endif

            <span class="sa-eyebrow">Système</span>
            <h1 class="sa-section-title">Maintenance & <em>Logs</em></h1>

            <div class="sa-grid-2">
                {{-- Mode maintenance --}}
                <div class="sa-card">
                    <div class="sa-card__head">
                        <span class="sa-card__title">🔧 Mode maintenance</span>
                    </div>
                    <div class="sa-maintenance-status">
                        <span class="sa-status-big {{ $isMaintenance ? 'sa-status-big--down' : 'sa-status-big--online' }}">
                            {{ $isMaintenance ? '🔴 En maintenance' : '🟢 En ligne' }}
                        </span>
                        <form method="POST" action="{{ route('superadmin.maintenance.toggle') }}">
                            @csrf
                            <button type="submit"
                                    class="sa-btn {{ $isMaintenance ? 'sa-btn--success' : 'sa-btn--danger' }}"
                                    onclick="return confirm('{{ $isMaintenance ? 'Remettre la plateforme en ligne ?' : 'Mettre la plateforme en maintenance ? Les utilisateurs verront une page d\'interruption.' }}')">
                                {{ $isMaintenance ? '✓ Remettre en ligne' : '⚠ Activer la maintenance' }}
                            </button>
                        </form>
                    </div>
                    <div style="padding: 0 1.5rem 1.25rem; font-size:.82rem; color: var(--subtext); line-height:1.6">
                        @if($isMaintenance)
                            La plateforme est actuellement hors ligne pour les utilisateurs. Seul le Super Admin peut y accéder.
                        @else
                            La plateforme est accessible à tous. Activez la maintenance avant d'effectuer des opérations critiques.
                        @endif
                    </div>
                </div>

                {{-- Cache --}}
                <div class="sa-card">
                    <div class="sa-card__head">
                        <span class="sa-card__title">⚡ Gestion du cache</span>
                    </div>
                    <div style="padding:1.25rem 1.5rem;font-size:.85rem;color:var(--subtext);line-height:1.65">
                        Videz le cache après chaque mise à jour de configuration, de routes ou de vues pour que les modifications soient prises en compte.
                    </div>
                    <div class="sa-cache-btns">
                        @foreach(['all' => 'Tout vider', 'config' => 'Config', 'route' => 'Routes', 'view' => 'Vues', 'app' => 'App Cache'] as $type => $label)
                        <form method="POST" action="{{ route('superadmin.cache.clear') }}">
                            @csrf
                            <input type="hidden" name="type" value="{{ $type }}">
                            <button type="submit" class="sa-btn sa-btn--ghost">{{ $label }}</button>
                        </form>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Logs complets --}}
            <div class="sa-card">
                <div class="sa-card__head">
                    <span class="sa-card__title">📋 Logs Laravel (50 dernières lignes)</span>
                </div>
                <div class="sa-log" id="log-full">
                    @forelse($logLines as $line)
                        @php
                            $cls = 'sa-log-line';
                            if(str_contains($line,'ERROR')||str_contains($line,'CRITICAL')) $cls .= ' sa-log-line--error';
                            elseif(str_contains($line,'WARNING')||str_contains($line,'SUPERADMIN')) $cls .= ' sa-log-line--warn';
                        @endphp
                        <div class="{{ $cls }}">{{ $line }}</div>
                    @empty
                        <div class="sa-log-line" style="color:var(--subtext)">// Aucun log disponible — le fichier storage/logs/laravel.log est vide ou inexistant.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
<script>
const l = document.getElementById('log-full');
if(l) l.scrollTop = l.scrollHeight;
</script>
</body>
</html>