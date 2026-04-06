<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion — UrbanSignal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;900&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
   :root {
  --sand:   #F4F7FC;   /* fond général — blanc bleuté */
  --navy:   #1B2F6E;   /* bleu marine profond — navbar, hero, footer */
  --royal:  #2952A3;   /* bleu royal — boutons primaires, titres */
  --sky:    #5B9BD5;   /* bleu ciel — icônes, accents */
  --gold:   #E8B84B;   /* or chaud — CTAs, eyebrows, ambre */
  --ink:    #0D1B3E;   /* quasi-noir bleuté — textes */
  --smoke:  #6B7FA3;   /* gris-bleu — textes secondaires */
  --mist:   #EBF1FA;   /* bleu très pâle — fonds de cards */
  --line:   rgba(27,47,110,.09);
  --white:  #FFFFFF;

  /* Aliases pour compatibilité avec le code existant */
  --forest: var(--navy);
  --olive:  var(--royal);
  --clay:   var(--gold);
  --amber:  var(--gold);
}

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--sand);
      color: var(--ink);
      -webkit-font-smoothing: antialiased;
      min-height: 100vh;
    }

    /* ── Split layout ── */
    .auth-shell {
      display: grid;
      grid-template-columns: 1fr;
      min-height: 100vh;
    }
    @media(min-width: 900px) {
      .auth-shell { grid-template-columns: 1fr 1fr; }
    }

    /* ══════════════════════════
       LEFT PANEL
    ══════════════════════════ */
    .auth-panel {
      display: none;
      position: relative;
      background: var(--forest);
      overflow: hidden;
      padding: 3rem;
      flex-direction: column;
      justify-content: space-between;
    }
    @media(min-width: 900px) { .auth-panel { display: flex; } }

    .auth-panel__grain {
      position: absolute; inset: 0; pointer-events: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='g'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23g)' opacity='0.07'/%3E%3C/svg%3E");
      opacity: .45;
    }
    .auth-panel__dots {
      position: absolute; inset: 0; pointer-events: none;
      background-image: radial-gradient(circle, rgba(255,255,255,.09) 1px, transparent 1px);
      background-size: 26px 26px;
    }
    .auth-panel__glow {
      position: absolute; bottom: -10%; right: -10%;
      width: 420px; height: 420px; border-radius: 50%;
      background: radial-gradient(circle, rgba(201,107,53,.18) 0%, transparent 65%);
      pointer-events: none;
    }
    .auth-panel__ghost {
      position: absolute; bottom: -2rem; left: -1rem;
      font-family: 'Montserrat', sans-serif;
      font-size: clamp(6rem, 12vw, 10rem); font-weight: 900;
      color: rgba(255,255,255,.03);
      line-height: 1; pointer-events: none; user-select: none;
      white-space: nowrap;
    }

    .auth-panel__top { position: relative; z-index: 2; }

    .auth-panel__logo {
      display: flex; align-items: center; gap: .65rem;
      text-decoration: none; margin-bottom: 3rem;
    }
    .auth-panel__mark {
      width: 38px; height: 38px; border-radius: 10px;
      background: var(--clay);
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 3px 16px rgba(201,107,53,.4);
    }
    .auth-panel__brand {
      font-family: 'Montserrat', sans-serif;
      font-weight: 900; font-size: 1.15rem; color: #fff;
    }
    .auth-panel__brand em { font-style: italic; color: var(--amber); }

    .auth-panel__headline {
      font-family: 'Montserrat', sans-serif;
      font-weight: 900;
      font-size: clamp(2rem, 3.5vw, 2.8rem);
      color: #fff; line-height: 1.1; letter-spacing: -.02em;
      margin-bottom: 1.25rem;
    }
    .auth-panel__headline em { font-style: italic; color: var(--amber); }

    .auth-panel__desc {
      font-size: .95rem; line-height: 1.75;
      color: rgba(255,255,255,.45); font-weight: 300;
      max-width: 320px;
    }

    .auth-panel__bottom { position: relative; z-index: 2; }

    .auth-panel__pills { display: flex; flex-direction: column; gap: .65rem; }
    .auth-panel__pill {
      display: flex; align-items: center; gap: .6rem;
      font-size: .82rem; color: rgba(255,255,255,.5); font-weight: 300;
    }
    .auth-panel__pill-dot {
      width: 7px; height: 7px; border-radius: 50%;
      background: #6EE7A0; flex-shrink: 0;
      animation: breathe 2.4s ease-in-out infinite;
    }
    @keyframes breathe {
      0%,100% { transform: scale(1); opacity: 1; }
      50%      { transform: scale(.65); opacity: .45; }
    }

    /* ══════════════════════════
       RIGHT PANEL — FORM
    ══════════════════════════ */
    .auth-form-wrap {
      display: flex; align-items: center; justify-content: center;
      padding: 2.5rem 1.5rem;
      min-height: 100vh;
    }
    @media(min-width: 900px) { .auth-form-wrap { padding: 3rem; } }

    .auth-card {
      width: 100%; max-width: 420px;
      animation: auth-in .6s cubic-bezier(.22,1,.36,1) both;
    }
    @keyframes auth-in {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* Mobile logo */
    .auth-mobile-logo {
      display: flex; align-items: center; gap: .6rem;
      text-decoration: none; margin-bottom: 2.5rem;
    }
    @media(min-width: 900px) { .auth-mobile-logo { display: none; } }

    .auth-mobile-mark {
      width: 34px; height: 34px; border-radius: 9px;
      background: var(--clay);
      display: flex; align-items: center; justify-content: center;
    }
    .auth-mobile-name {
      font-family: 'Montserrat', sans-serif;
      font-weight: 900; font-size: 1.1rem; color: var(--ink);
    }
    .auth-mobile-name em { font-style: italic; color: var(--clay); }

    /* Card header */
    .auth-eyebrow {
      font-size: .7rem; font-weight: 600;
      letter-spacing: .16em; text-transform: uppercase;
      color: var(--clay); margin-bottom: .55rem; display: block;
    }
    .auth-title {
      font-family: 'Montserrat', sans-serif;
      font-weight: 900; font-size: 2rem; color: var(--ink);
      letter-spacing: -.02em; line-height: 1.1; margin-bottom: .4rem;
    }
    .auth-sub {
      font-size: .88rem; color: var(--smoke);
      font-weight: 300; line-height: 1.5; margin-bottom: 2.25rem;
    }

    /* Session status */
    .auth-status {
      background: rgba(41,82,163,.08);
      border: 1px solid rgba(41,82,163,.2);
      border-radius: 10px;
      padding: .75rem 1rem;
      font-size: .85rem; color: var(--forest);
      margin-bottom: 1.5rem;
    }

    /* Fields */
    .auth-field { margin-bottom: 1.25rem; }

    .auth-label {
      display: block;
      font-size: .78rem; font-weight: 600;
      letter-spacing: .06em; text-transform: uppercase;
      color: var(--smoke); margin-bottom: .45rem;
    }

    .auth-input {
      width: 100%;
      background: #fff;
      border: 1.5px solid rgba(15,31,23,.12);
      border-radius: 11px;
      padding: .78rem 1rem;
      font-family: 'Poppins', sans-serif;
      font-size: .92rem; color: var(--ink);
      outline: none;
      transition: border-color .2s, box-shadow .2s;
    }
    .auth-input::placeholder { color: rgba(110,125,115,.4); }
    .auth-input:focus {
      border-color: var(--olive);
      box-shadow: 0 0 0 3px rgba(41,82,163,.1);
    }

    /* Error */
    .auth-error {
      display: flex; align-items: center; gap: .4rem;
      font-size: .78rem; color: #DC2626; margin-top: .4rem;
    }
    .auth-error::before {
      content: ''; display: inline-block;
      width: 5px; height: 5px; border-radius: 50%;
      background: #DC2626; flex-shrink: 0;
    }

    /* Remember */
    .auth-remember {
      display: inline-flex; align-items: center; gap: .55rem; cursor: pointer;
    }
    .auth-checkbox {
      width: 17px; height: 17px; border-radius: 5px;
      border: 1.5px solid rgba(15,31,23,.2);
      accent-color: var(--forest); cursor: pointer;
    }
    .auth-remember-label {
      font-size: .85rem; color: var(--smoke); font-weight: 400;
    }

    /* Hide native browser password reveal button (Edge/Chrome) */
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear { display: none; }

    /* Password toggle */
    .auth-pw-wrap {
      position: relative;
    }
    .auth-pw-wrap .auth-input {
      padding-right: 2.8rem;
    }
    .auth-pw-toggle {
      position: absolute; top: 50%; right: .85rem;
      transform: translateY(-50%);
      background: none; border: none; cursor: pointer;
      color: var(--smoke); padding: 0; line-height: 1;
      transition: color .18s;
    }
    .auth-pw-toggle:hover { color: var(--ink); }

    /* Actions */
    .auth-actions {
      display: flex; align-items: center;
      justify-content: space-between;
      gap: 1rem; margin-top: 1.75rem; flex-wrap: wrap;
    }

    .auth-forgot {
      font-size: .82rem; font-weight: 400;
      color: var(--smoke); text-decoration: none;
      transition: color .18s;
    }
    .auth-forgot:hover { color: var(--ink); }

    .auth-submit {
      display: inline-flex; align-items: center; gap: .5rem;
      background: var(--forest); color: #fff;
      font-family: 'Poppins', sans-serif;
      font-weight: 600; font-size: .92rem;
      padding: .78rem 1.6rem;
      border-radius: 11px; border: none; cursor: pointer;
      box-shadow: 0 6px 24px rgba(27,47,110,.22);
      transition: background .18s, transform .2s, box-shadow .2s;
    }
    .auth-submit:hover {
      background: #1a2b62;
      transform: translateY(-1px);
      box-shadow: 0 10px 32px rgba(27,47,110,.3);
    }

    /* Divider */
    .auth-divider {
      display: flex; align-items: center; gap: .75rem;
      margin: 1.75rem 0 1.5rem;
    }
    .auth-divider::before, .auth-divider::after {
      content: ''; flex: 1; height: 1px; background: var(--line);
    }
    .auth-divider-text {
      font-size: .72rem; font-weight: 500;
      letter-spacing: .1em; text-transform: uppercase;
      color: rgba(110,125,115,.5);
    }

    /* Footer */
    .auth-footer-text {
      text-align: center;
      font-size: .88rem; color: var(--smoke); font-weight: 300;
    }
    .auth-footer-link {
      color: var(--clay); font-weight: 600;
      text-decoration: none; transition: color .18s;
    }
    .auth-footer-link:hover { color: #B85C2A; }
    </style>
</head>
<body>

<div class="auth-shell">

    {{-- ── Left brand panel ── --}}
    <div class="auth-panel">
        <div class="auth-panel__grain"></div>
        <div class="auth-panel__dots"></div>
        <div class="auth-panel__glow"></div>
        <span class="auth-panel__ghost">Signal</span>

        <div class="auth-panel__top">
            <a href="{{ route('home') }}" class="auth-panel__logo">
                <div class="auth-panel__mark">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                        <path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="auth-panel__brand">Urban<em>Signal</em></span>
            </a>

            <h2 class="auth-panel__headline">
                La voirie de <em>Ouidah</em><br>a besoin de vous.
            </h2>
            <p class="auth-panel__desc">
                Signalez les dégradations, suivez leur traitement et participez à l'amélioration de votre commune.
            </p>
        </div>

        <div class="auth-panel__bottom">
            <div class="auth-panel__pills">
                <div class="auth-panel__pill"><span class="auth-panel__pill-dot"></span>Signalement en moins de 2 minutes</div>
                <div class="auth-panel__pill"><span class="auth-panel__pill-dot"></span>Suivi en temps réel par ticket</div>
                <div class="auth-panel__pill"><span class="auth-panel__pill-dot"></span>Service gratuit pour tous les citoyens</div>
            </div>
        </div>
    </div>

    {{-- ── Right form panel ── --}}
    <div class="auth-form-wrap">
        <div class="auth-card">

            {{-- Mobile logo --}}
            <a href="{{ route('home') }}" class="auth-mobile-logo">
                <div class="auth-mobile-mark">
                    <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                        <path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="auth-mobile-name">Urban<em>Signal</em></span>
            </a>

            <span class="auth-eyebrow">Espace citoyen</span>
            <h1 class="auth-title">Connexion</h1>
            <p class="auth-sub">Accédez à votre espace UrbanSignal.</p>

            {{-- Session status --}}
            @if(session('status'))
                <div class="auth-status">{{ session('status') }}</div>
            @endif
            @if(session('error'))
                <div class="auth-error">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="auth-field">
                    <label for="email" class="auth-label">Adresse email</label>
                    <input id="email" type="email" name="email"
                           value="{{ old('email') }}"
                           class="auth-input"
                           placeholder="vous@exemple.com"
                           required autofocus autocomplete="username">
                    @error('email')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="password" class="auth-label">Mot de passe</label>
                    <div class="auth-pw-wrap">
                        <input id="password" type="password" name="password"
                               class="auth-input"
                               placeholder="••••••••"
                               required autocomplete="current-password">
                        <button type="button" class="auth-pw-toggle" onclick="togglePassword('password', this)" aria-label="Afficher/masquer le mot de passe">
                            <svg id="password-eye" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <label class="auth-remember">
                    <input id="remember_me" type="checkbox" name="remember" class="auth-checkbox">
                    <span class="auth-remember-label">Se souvenir de moi</span>
                </label>

                <div class="auth-actions">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="auth-forgot">Mot de passe oublié ?</a>
                    @endif
                    <button type="submit" class="auth-submit">
                        Se connecter
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>

                <div class="auth-divider">
                    <span class="auth-divider-text">Nouveau sur UrbanSignal ?</span>
                </div>

                <p class="auth-footer-text">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" class="auth-footer-link">Créer un compte gratuit</a>
                </p>
            </form>

        </div>
    </div>

</div>

<script>
function togglePassword(fieldId, btn) {
    var input = document.getElementById(fieldId);
    var isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    btn.querySelector('svg').innerHTML = isHidden
        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>'
        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
}
</script>
</body>
</html>