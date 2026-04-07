<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres — Super Admin UrbanSignal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600&family=Montserrat:wght@400;500;600;700;900&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    :root{--bg:#080E1A;--surface:#0F1829;--card:#141F33;--border:rgba(99,179,237,.12);--royal:#2952A3;--sky:#5B9BD5;--gold:#E8B84B;--red:#EF4444;--green:#22C55E;--smoke:#6B7FA3;--mist:rgba(91,155,213,.06);--text:#E2EAF4;--subtext:#6B7FA3;--line:rgba(99,179,237,.1)}
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Outfit',sans-serif;background:var(--bg);color:var(--text);-webkit-font-smoothing:antialiased;min-height:100vh}
    .sa-shell{display:flex;min-height:100vh}
    .sa-sidebar{width:240px;flex-shrink:0;background:var(--surface);border-right:1px solid var(--border);display:flex;flex-direction:column;position:sticky;top:0;height:100vh;overflow-y:auto}
    .sa-sidebar__logo{padding:1.5rem 1.25rem 1rem;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:.65rem}
    .sa-sidebar__mark{ width: 50px; height: 50px; border-radius: 10px;
      background: transparent;
      display: flex; align-items: center; justify-content: center;
      box-shadow: none;
      flex-shrink: 0;}
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
    .sa-topbar{height:56px;background:var(--surface);border-bottom:1px solid var(--border);display:flex;align-items:center;padding:0 2rem;position:sticky;top:0;z-index:50}
    .sa-topbar__title{font-family:'Syne',sans-serif;font-weight:800;font-size:1.05rem;color:var(--text)}
    .sa-content{padding:2rem;flex:1;max-width:700px}
    .sa-eyebrow{font-size:.68rem;font-weight:600;letter-spacing:.16em;text-transform:uppercase;color:var(--gold);display:block;margin-bottom:.5rem}
    .sa-section-title{font-family:'Syne',sans-serif;font-weight:800;font-size:1.6rem;color:var(--text);letter-spacing:-.02em;margin-bottom:1.75rem}
    .sa-section-title em{font-style:italic;color:var(--sky)}
    .sa-flash{margin-bottom:1.5rem;padding:.85rem 1.1rem;border-radius:10px;font-size:.88rem;display:flex;align-items:center;gap:.65rem}
    .sa-flash--success{background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.2);color:#4ADE80}
    .sa-flash--error{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);color:#F87171}
    .sa-card{background:var(--card);border:1px solid var(--border);border-radius:16px;overflow:hidden;margin-bottom:1.5rem}
    .sa-card__head{padding:1rem 1.25rem;border-bottom:1px solid var(--border)}
    .sa-card__title{font-family:'Syne',sans-serif;font-weight:700;font-size:.95rem;color:var(--text)}
    .sa-card__body{padding:1.5rem;display:flex;flex-direction:column;gap:1.1rem}
    .sa-field{}
    .sa-label{display:block;font-size:.72rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--subtext);margin-bottom:.4rem}
    .sa-input{width:100%;background:var(--surface);border:1px solid var(--border);border-radius:9px;padding:.7rem 1rem;color:var(--text);font-family:'Outfit',sans-serif;font-size:.9rem;outline:none;transition:border-color .2s}
    .sa-input:focus{border-color:var(--sky)}
    .sa-input::placeholder{color:var(--subtext)}
    .sa-hint{font-size:.72rem;color:var(--subtext);margin-top:.3rem;font-weight:300}
    .sa-btn-submit{display:inline-flex;align-items:center;gap:.5rem;background:var(--royal);color:#fff;font-family:'Outfit',sans-serif;font-weight:600;font-size:.88rem;padding:.7rem 1.5rem;border-radius:10px;border:none;cursor:pointer;box-shadow:0 4px 16px rgba(41,82,163,.3);transition:background .18s,transform .18s}
    .sa-btn-submit:hover{background:#3562C0;transform:translateY(-1px)}
    .sa-warn-box{background:rgba(232,184,75,.06);border:1px solid rgba(232,184,75,.2);border-radius:12px;padding:1rem 1.25rem;font-size:.82rem;color:var(--gold);line-height:1.65}
    </style>
</head>
<body>
<div class="sa-shell">

    <aside class="sa-sidebar">
        <div class="sa-sidebar__logo">
            <div class="sa-sidebar__mark">  
                <img src="{{ asset('images/logo.svg') }}" alt="Logo UrbanSignal" style="width: 100%; height: 100%; object-fit: contain;">
            </div>
            <div><span class="sa-sidebar__name">Urban<em>Signal</em></span><span style="font-size:.6rem;color:var(--subtext);display:block">Ouidah</span></div>
        </div>
        <span class="sa-sidebar__role">⚡ Super Admin</span>
        <nav class="sa-nav">
            <a href="{{ route('superadmin.dashboard') }}" class="sa-nav__item"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>Dashboard</a>
            <a href="{{ route('superadmin.users') }}" class="sa-nav__item"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>Utilisateurs</a>
            <a href="{{ route('superadmin.maintenance') }}" class="sa-nav__item"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>Maintenance & Logs</a>
            <a href="{{ route('superadmin.settings') }}" class="sa-nav__item active"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>Paramètres</a>
            <div class="sa-nav__sep"></div>
            <a href="{{ route('superadmin.export.users') }}" class="sa-nav__item"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Export Utilisateurs</a>
            <a href="{{ route('superadmin.export.reports') }}" class="sa-nav__item"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Export Signalements</a>
            <div class="sa-nav__sep"></div>
            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="sa-nav__item sa-nav__danger"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>Déconnexion</button></form>
        </nav>
        <div class="sa-sidebar__footer"><strong>{{ auth()->user()->name }}</strong>{{ auth()->user()->email }}</div>
    </aside>

    <div class="sa-main">
        <header class="sa-topbar"><span class="sa-topbar__title">Paramètres globaux</span></header>
        <div class="sa-content">

            @if(session('success'))<div class="sa-flash sa-flash--success">✓ {{ session('success') }}</div>@endif
            @if(session('error'))<div class="sa-flash sa-flash--error">{{ session('error') }}</div>@endif

            <span class="sa-eyebrow">Configuration</span>
            <h1 class="sa-section-title">Paramètres <em>globaux</em></h1>

            <div class="sa-warn-box" style="margin-bottom:1.5rem">
                ⚠️ Ces paramètres modifient directement le fichier <code style="font-family:'JetBrains Mono',monospace;font-size:.85em">.env</code> de l'application. Un vidage du cache de configuration est effectué automatiquement après chaque modification.
            </div>

            <form method="POST" action="{{ route('superadmin.settings.update') }}">
                @csrf

                <div class="sa-card">
                    <div class="sa-card__head">
                        <span class="sa-card__title">🏛 Identité de la plateforme</span>
                    </div>
                    <div class="sa-card__body">
                        <div class="sa-field">
                            <label class="sa-label">Nom de la plateforme</label>
                            <input type="text" name="app_name" class="sa-input"
                                   value="{{ old('app_name', config('app.name')) }}"
                                   placeholder="UrbanSignal" required>
                            <p class="sa-hint">Affiché dans les titres de page et les emails.</p>
                        </div>

                        <div class="sa-field">
                            <label class="sa-label">Commune</label>
                            <input type="text" name="app_commune" class="sa-input"
                                   value="{{ old('app_commune', env('APP_COMMUNE', 'Commune de Ouidah')) }}"
                                   placeholder="Commune de Ouidah" required>
                            <p class="sa-hint">Nom officiel affiché dans le footer et les entêtes.</p>
                        </div>

                        <div class="sa-field">
                            <label class="sa-label">Email de contact</label>
                            <input type="email" name="app_email" class="sa-input"
                                   value="{{ old('app_email', env('APP_EMAIL', '')) }}"
                                   placeholder="contact@mairie-ouidah.bj" required>
                            <p class="sa-hint">Adresse affichée dans le footer et utilisée pour les notifications.</p>
                        </div>

                        <div class="sa-field">
                            <label class="sa-label">Téléphone de contact</label>
                            <input type="text" name="app_phone" class="sa-input"
                                   value="{{ old('app_phone', env('APP_PHONE', '')) }}"
                                   placeholder="+229 22 34 10 91">
                            <p class="sa-hint">Optionnel — affiché dans le footer.</p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="sa-btn-submit">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Enregistrer les paramètres
                </button>
            </form>

        </div>
    </div>
</div>
</body>
</html>