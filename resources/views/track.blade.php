@extends('layouts.app')
@section('title', 'Suivre un signalement')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;900&family=Poppins:wght@300;400;500;600&display=swap');

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

*, *::before, *::after { box-sizing: border-box; }
body { background: var(--sand); font-family: 'Poppins', sans-serif; }

/* ════ PAGE HEADER ════ */
.tk-header {
  background: var(--forest);
  position: relative;
  overflow: hidden;
  padding: 4rem 2rem 7rem;
  text-align: center;
}

.tk-header::before {
  content: '';
  position: absolute; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='g'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23g)' opacity='0.07'/%3E%3C/svg%3E");
  opacity: .45; pointer-events: none;
}
.tk-header::after {
  content: '';
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  width: 600px; height: 600px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(41,82,163,.22) 0%, transparent 65%);
  pointer-events: none;
}

.tk-header__inner {
  position: relative; z-index: 2;
  max-width: 580px; margin: 0 auto;
}

.tk-eyebrow {
  font-size: .72rem; font-weight: 600;
  letter-spacing: .18em; text-transform: uppercase;
  color: var(--amber); display: block; margin-bottom: .65rem;
}

.tk-header h1 {
  font-family: 'Montserrat', sans-serif;
  font-weight: 900;
  font-size: clamp(2rem, 4.5vw, 3rem);
  color: #fff;
  letter-spacing: -.02em; line-height: 1.1;
  margin-bottom: .85rem;
}
.tk-header h1 em { font-style: italic; color: var(--amber); }

.tk-header p {
  font-size: .96rem; line-height: 1.7;
  color: rgba(255,255,255,.45);
  font-weight: 300;
  margin-bottom: 2.5rem;
}

/* search form inside header */
.tk-form {
  display: flex; gap: .75rem;
  max-width: 480px; margin: 0 auto;
}
.tk-input {
  flex: 1;
  background: rgba(255,255,255,.08);
  border: 1px solid rgba(255,255,255,.15);
  border-radius: 12px;
  padding: .9rem 1.2rem;
  color: #fff;
  font-family: 'Poppins', sans-serif; font-size: .9rem;
  outline: none;
  transition: border-color .2s, background .2s;
}
.tk-input::placeholder { color: rgba(255,255,255,.28); }
.tk-input:focus {
  border-color: var(--amber);
  background: rgba(255,255,255,.12);
}
.tk-btn-search {
  background: var(--clay); color: #fff;
  font-family: 'Poppins', sans-serif;
  font-weight: 600; font-size: .9rem;
  padding: .9rem 1.6rem;
  border-radius: 12px; border: none; cursor: pointer;
  white-space: nowrap;
  box-shadow: 0 4px 20px rgba(201,107,53,.38);
  transition: background .18s, transform .2s;
}
.tk-btn-search:hover { background: #D97840; transform: translateY(-1px); }

.tk-header__wave {
  position: absolute; bottom: 0; left: 0; right: 0;
  line-height: 0; z-index: 3;
}

/* ════ CONTENT AREA ════ */
.tk-body {
  max-width: 780px;
  margin: -2.5rem auto 0;
  padding: 0 1.5rem 5rem;
  position: relative; z-index: 10;
}

/* entrance */
@keyframes tk-up {
  from { opacity: 0; transform: translateY(24px); }
  to   { opacity: 1; transform: translateY(0); }
}
.tk-card { animation: tk-up .6s cubic-bezier(.22,1,.36,1) both; }

/* ════ NOT FOUND ════ */
.tk-empty {
  background: var(--white);
  border-radius: 22px;
  box-shadow: 0 20px 60px rgba(15,31,23,.1);
  padding: 3.5rem 2rem;
  text-align: center;
}
.tk-empty__icon {
  width: 64px; height: 64px;
  border-radius: 18px;
  background: #FEF3E2;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 1.25rem;
}
.tk-empty__title {
  font-family: 'Montserrat', sans-serif;
  font-weight: 700; font-size: 1.3rem;
  color: var(--ink); margin-bottom: .5rem;
}
.tk-empty__sub {
  font-size: .9rem; color: var(--smoke);
  font-weight: 300; line-height: 1.6;
}
.tk-empty__sub strong { font-weight: 600; color: var(--clay); }

/* ════ REPORT CARD ════ */
.tk-report {
  background: var(--white);
  border-radius: 22px;
  box-shadow: 0 20px 60px rgba(15,31,23,.1);
  overflow: hidden;
}

/* ── Report Header ── */
.tk-report__head {
  padding: 2rem 2rem 1.75rem;
  border-bottom: 1px solid var(--line);
  display: flex; flex-wrap: wrap;
  align-items: flex-start;
  justify-content: space-between;
  gap: 1rem;
}

.tk-ticket-num {
  font-family: 'Poppins', sans-serif;
  font-size: .72rem; font-weight: 600;
  letter-spacing: .14em; text-transform: uppercase;
  color: var(--smoke); margin-bottom: .45rem;
  display: flex; align-items: center; gap: .4rem;
}
.tk-ticket-num::before {
  content: '';
  display: inline-block;
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--olive);
}

.tk-report__title {
  font-family: 'Montserrat', sans-serif;
  font-weight: 700; font-size: 1.4rem;
  color: var(--ink); line-height: 1.2;
  margin-bottom: .35rem;
}

.tk-report__meta {
  font-size: .82rem; color: var(--smoke);
  font-weight: 300;
}

/* status badge */
.tk-status {
  display: inline-flex; align-items: center; gap: .45rem;
  padding: .45rem 1rem;
  border-radius: 999px;
  font-family: 'Poppins', sans-serif;
  font-size: .78rem; font-weight: 600;
  letter-spacing: .04em;
  white-space: nowrap;
  border: 1.5px solid currentColor;
}
.tk-status--submitted  { color: var(--smoke);  background: rgba(110,125,115,.08); }
.tk-status--validated  { color: #2563EB;       background: rgba(37,99,235,.07);  }
.tk-status--in_progress{ color: var(--clay);   background: rgba(201,107,53,.09); }
.tk-status--resolved   { color: var(--olive);  background: rgba(41,82,163,.09);  }
.tk-status--archived   { color: #64748B;       background: rgba(100,116,139,.07);}

/* ── Progress Timeline ── */
.tk-progress {
  padding: 1.75rem 2rem;
  background: var(--mist);
  border-bottom: 1px solid var(--line);
}

.tk-section-label {
  font-size: .7rem; font-weight: 600;
  letter-spacing: .16em; text-transform: uppercase;
  color: var(--smoke); margin-bottom: 1.5rem;
  display: block;
}

.tk-timeline {
  display: flex; align-items: center;
}

.tk-step {
  display: flex; flex-direction: column;
  align-items: center; flex: 1; position: relative;
}

.tk-step__dot {
  width: 36px; height: 36px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-family: 'Poppins', sans-serif;
  font-size: .75rem; font-weight: 600;
  position: relative; z-index: 1;
  transition: transform .2s;
}
.tk-step__dot--done    { background: var(--forest); color: #fff; }
.tk-step__dot--active  { background: var(--clay); color: #fff; box-shadow: 0 0 0 4px rgba(201,107,53,.2); }
.tk-step__dot--pending { background: var(--white); color: var(--smoke); border: 1.5px solid rgba(15,31,23,.12); }

.tk-step__label {
  font-size: .75rem; font-weight: 500;
  margin-top: .6rem; text-align: center; line-height: 1.3;
}
.tk-step__label--done   { color: var(--forest); }
.tk-step__label--active { color: var(--clay); font-weight: 600; }
.tk-step__label--pending{ color: var(--smoke); }

.tk-connector {
  flex: 1; height: 2px;
  margin-bottom: 1.4rem;
  border-radius: 2px;
}
.tk-connector--done    { background: var(--forest); }
.tk-connector--pending { background: rgba(15,31,23,.1); }

/* ── Details Grid ── */
.tk-details {
  padding: 1.75rem 2rem;
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.75rem;
  border-bottom: 1px solid var(--line);
}
@media(min-width:600px){ .tk-details { grid-template-columns: 1fr 1fr; } }

.tk-field__label {
  font-size: .7rem; font-weight: 600;
  letter-spacing: .14em; text-transform: uppercase;
  color: var(--smoke); margin-bottom: .45rem; display: block;
}

.tk-field__value {
  font-size: .9rem; color: var(--ink);
  line-height: 1.65; font-weight: 400;
}
.tk-field__value--resolved {
  color: var(--olive); font-weight: 600;
}

/* ── Photos ── */
.tk-photos {
  padding: 1.75rem 2rem;
  border-bottom: 1px solid var(--line);
}
.tk-photos__grid {
  display: flex; gap: .75rem; flex-wrap: wrap;
  margin-top: 1rem;
}
.tk-photo {
  width: 88px; height: 88px;
  object-fit: cover;
  border-radius: 12px;
  border: 1.5px solid var(--line);
  cursor: pointer;
  transition: transform .2s, box-shadow .2s;
}
.tk-photo:hover {
  transform: scale(1.04);
  box-shadow: 0 8px 24px rgba(15,31,23,.14);
}

/* ── History ── */
.tk-history {
  padding: 1.75rem 2rem;
}

.tk-history__list { margin-top: 1.2rem; }

.tk-history__item {
  display: flex; gap: 1rem;
  position: relative; padding-bottom: 1.4rem;
}
.tk-history__item:last-child { padding-bottom: 0; }

/* vertical line */
.tk-history__item:not(:last-child)::before {
  content: '';
  position: absolute;
  left: 5px; top: 14px;
  bottom: 0;
  width: 1px;
  background: var(--line);
}

.tk-history__dot {
  width: 12px; height: 12px;
  border-radius: 50%;
  background: var(--olive);
  flex-shrink: 0;
  margin-top: .3rem;
  border: 2px solid var(--white);
  box-shadow: 0 0 0 1.5px var(--olive);
}

.tk-history__new {
  font-size: .88rem; font-weight: 600;
  color: var(--ink); margin-bottom: .15rem;
}
.tk-history__old {
  font-size: .75rem; color: var(--smoke);
  margin-left: .4rem; font-weight: 300;
}
.tk-history__comment {
  font-size: .82rem; color: var(--smoke);
  font-weight: 300; line-height: 1.55;
  margin-top: .2rem;
}
.tk-history__date {
  font-size: .75rem; color: rgba(110,125,115,.65);
  margin-top: .25rem;
}
</style>
@endpush

@section('content')

{{-- ════ HEADER ════ --}}
<section class="tk-header">
    <div class="tk-header__inner">
        <span class="tk-eyebrow">Suivi en ligne</span>
        <h1>Suivre mon <em>signalement</em></h1>
        <p>Entrez votre numéro de ticket pour consulter l'état exact de votre signalement.</p>

        <form action="{{ route('track') }}" method="GET" class="tk-form">
            <input type="text" name="ticket"
                   placeholder="Ex : US-2024-00001"
                   value="{{ request('ticket') }}"
                   class="tk-input"
                   required>
            <button type="submit" class="tk-btn-search">Rechercher</button>
        </form>
    </div>

    <div class="tk-header__wave">
        <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 80L1440 80L1440 35C1060 78 700 8 380 38C175 57 65 20 0 35Z" fill="#F5EFE4"/>
        </svg>
    </div>
</section>

{{-- ════ BODY ════ --}}
<div class="tk-body">

    {{-- ── Not Found ── --}}
    @if(request('ticket') && !$report)
    <div class="tk-empty tk-card">
        <div class="tk-empty__icon">
            <svg width="28" height="28" fill="none" stroke="#E5A03A" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h2 class="tk-empty__title">Ticket introuvable</h2>
        <p class="tk-empty__sub">
            Aucun signalement trouvé avec le numéro <strong>{{ request('ticket') }}</strong>.<br>
            Vérifiez la saisie et réessayez.
        </p>
    </div>
    @endif

    {{-- ── Report Card ── --}}
    @if($report)
    @php
        $statusLabels = ['submitted'=>'Soumis','validated'=>'Validé','in_progress'=>'En cours','resolved'=>'Résolu','archived'=>'Archivé'];
        $timelineSteps = ['submitted'=>'Soumis','validated'=>'Validé','in_progress'=>'En cours','resolved'=>'Résolu'];
        $currentIndex = array_search($report->status, array_keys($timelineSteps));
        if($currentIndex === false) $currentIndex = -1;
    @endphp
    <div class="tk-report tk-card">

        {{-- Header --}}
        <div class="tk-report__head">
            <div>
                <div class="tk-ticket-num">{{ $report->ticket_number }}</div>
                <h2 class="tk-report__title">{{ $report->title }}</h2>
                <p class="tk-report__meta">{{ $report->category->name }} • {{ $report->arrondissement->name ?? 'N/A' }}</p>
            </div>

            @php
                $statusClass = match($report->status) {
                    'validated'   => 'tk-status--validated',
                    'in_progress' => 'tk-status--in_progress',
                    'resolved'    => 'tk-status--resolved',
                    'archived'    => 'tk-status--archived',
                    default       => 'tk-status--submitted',
                };
                $statusIcon = match($report->status) {
                    'resolved'    => '✓',
                    'in_progress' => '↻',
                    'validated'   => '◈',
                    default       => '○',
                };
            @endphp
            <span class="tk-status {{ $statusClass }}">
                {{ $statusIcon }} {{ $statusLabels[$report->status] ?? $report->status }}
            </span>
        </div>

        {{-- Progress --}}
        <div class="tk-progress">
            <span class="tk-section-label">Progression du traitement</span>
            <div class="tk-timeline">
                @foreach($timelineSteps as $key => $label)
                    @php
                        $idx = array_search($key, array_keys($timelineSteps));
                        $isDone    = $idx < $currentIndex;
                        $isActive  = $idx === $currentIndex;
                        $isPending = $idx > $currentIndex;
                        $dotClass  = $isDone ? 'tk-step__dot--done' : ($isActive ? 'tk-step__dot--active' : 'tk-step__dot--pending');
                        $lblClass  = $isDone ? 'tk-step__label--done' : ($isActive ? 'tk-step__label--active' : 'tk-step__label--pending');
                    @endphp

                    <div class="tk-step">
                        <div class="tk-step__dot {{ $dotClass }}">
                            @if($isDone)
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            @else
                                {{ $idx + 1 }}
                            @endif
                        </div>
                        <span class="tk-step__label {{ $lblClass }}">{{ $label }}</span>
                    </div>

                    @if(!$loop->last)
                        <div class="tk-connector {{ $isDone ? 'tk-connector--done' : 'tk-connector--pending' }}"></div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Details --}}
        <div class="tk-details">
            <div>
                <span class="tk-field__label">Description</span>
                <p class="tk-field__value">{{ $report->description }}</p>
            </div>

            <div style="display:flex; flex-direction:column; gap:1.25rem;">
                <div>
                    <span class="tk-field__label">Date de signalement</span>
                    <p class="tk-field__value">{{ $report->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                @if($report->address)
                <div>
                    <span class="tk-field__label">Adresse</span>
                    <p class="tk-field__value">{{ $report->address }}</p>
                </div>
                @endif
                @if($report->resolved_at)
                <div>
                    <span class="tk-field__label">Résolu le</span>
                    <p class="tk-field__value tk-field__value--resolved">{{ $report->resolved_at->format('d/m/Y à H:i') }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Photos --}}
        @if($report->photos->count())
        <div class="tk-photos">
            <span class="tk-section-label">Photos jointes</span>
            <div class="tk-photos__grid">
                @foreach($report->photos as $photo)
                <img src="{{ asset('storage/' . $photo->path) }}"
                     alt="{{ $photo->original_name }}"
                     class="tk-photo">
                @endforeach
            </div>
        </div>
        @endif

        {{-- History --}}
        @if($report->statusHistories->count())
        <div class="tk-history">
            <span class="tk-section-label">Historique des mises à jour</span>
            <div class="tk-history__list">
                @foreach($report->statusHistories->sortByDesc('created_at') as $history)
                <div class="tk-history__item">
                    <div class="tk-history__dot"></div>
                    <div>
                        <div>
                            <span class="tk-history__new">{{ $history->new_status_label }}</span>
                            @if($history->old_status)
                            <span class="tk-history__old">← {{ $history->old_status_label }}</span>
                            @endif
                        </div>
                        @if($history->comment)
                        <p class="tk-history__comment">{{ $history->comment }}</p>
                        @endif
                        <p class="tk-history__date">{{ $history->created_at->format('d/m/Y H:i') }}</p>
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