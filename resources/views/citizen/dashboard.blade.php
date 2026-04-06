@extends('layouts.app')
@section('title', 'Mes signalements')

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

/* ── Page wrapper ── */
.cd-wrap {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2.5rem 2rem 5rem;
}
@media(max-width: 640px) { .cd-wrap { padding: 1.75rem 1.25rem 4rem; } }

/* ── Page header ── */
.cd-header {
  display: flex; flex-wrap: wrap;
  align-items: flex-start; justify-content: space-between;
  gap: 1.25rem; margin-bottom: 2.5rem;
}

.cd-header__greeting {
  font-size: .72rem; font-weight: 600;
  letter-spacing: .16em; text-transform: uppercase;
  color: var(--clay); margin-bottom: .45rem;
  display: flex; align-items: center; gap: .45rem;
}
.cd-header__greeting-dot {
  width: 6px; height: 6px; border-radius: 50%;
  background: #6EE7A0;
  animation: cd-breathe 2.4s ease-in-out infinite;
}
@keyframes cd-breathe {
  0%,100% { opacity: 1; transform: scale(1); }
  50%      { opacity: .4; transform: scale(.65); }
}

.cd-header__title {
  font-family: 'Montserrat', sans-serif;
  font-weight: 900;
  font-size: clamp(1.7rem, 3vw, 2.4rem);
  color: var(--ink); letter-spacing: -.02em; line-height: 1.1;
}
.cd-header__title em { font-style: italic; color: var(--olive); }

.cd-btn-new {
  display: inline-flex; align-items: center; gap: .5rem;
  background: var(--clay); color: #fff;
  font-family: 'Poppins', sans-serif;
  font-weight: 600; font-size: .88rem;
  padding: .78rem 1.5rem; border-radius: 11px;
  text-decoration: none; flex-shrink: 0;
  box-shadow: 0 5px 20px rgba(201,107,53,.32);
  transition: background .18s, transform .2s, box-shadow .2s;
}
.cd-btn-new:hover {
  background: #D97840;
  transform: translateY(-2px);
  box-shadow: 0 10px 28px rgba(201,107,53,.4);
}

/* ── Stats grid ── */
.cd-stats {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1px;
  background: rgba(15,31,23,.08);
  border: 1px solid rgba(15,31,23,.08);
  border-radius: 18px;
  overflow: hidden;
  margin-bottom: 2.5rem;
  box-shadow: 0 8px 32px rgba(15,31,23,.07);
}
@media(min-width: 700px) { .cd-stats { grid-template-columns: repeat(4, 1fr); } }

.cd-stat {
  background: var(--white);
  padding: 1.5rem 1.5rem 1.35rem;
  position: relative;
  transition: background .2s;
}
.cd-stat:hover { background: var(--mist); }
.cd-stat::before {
  content: '';
  position: absolute; left: 0; top: 20%; bottom: 20%;
  width: 3px; border-radius: 0 3px 3px 0;
  background: var(--c, var(--smoke));
}

.cd-stat__num {
  font-family: 'Montserrat', sans-serif;
  font-weight: 700; font-size: 2.2rem;
  line-height: 1; letter-spacing: -.03em;
  color: var(--ink); margin-bottom: .35rem;
}

.cd-stat__label {
  font-size: .72rem; font-weight: 600;
  letter-spacing: .08em; text-transform: uppercase;
  color: var(--smoke);
}

/* ── Empty state ── */
.cd-empty {
  background: var(--white);
  border-radius: 20px;
  border: 1px solid rgba(15,31,23,.07);
  box-shadow: 0 8px 32px rgba(15,31,23,.07);
  padding: 5rem 2rem;
  text-align: center;
}

.cd-empty__icon {
  width: 72px; height: 72px; border-radius: 20px;
  background: var(--mist);
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 1.5rem;
}

.cd-empty__title {
  font-family: 'Montserrat', sans-serif;
  font-weight: 700; font-size: 1.4rem;
  color: var(--ink); margin-bottom: .5rem;
}

.cd-empty__sub {
  font-size: .9rem; color: var(--smoke);
  font-weight: 300; line-height: 1.65;
  margin-bottom: 2rem;
}

/* ── Table card ── */
.cd-table-card {
  background: var(--white);
  border-radius: 20px;
  border: 1px solid rgba(15,31,23,.07);
  box-shadow: 0 8px 32px rgba(15,31,23,.07);
  overflow: hidden;
}

.cd-table-wrap { overflow-x: auto; }

table.cd-table {
  width: 100%;
  border-collapse: collapse;
}

.cd-table thead {
  background: var(--mist);
  border-bottom: 1px solid rgba(15,31,23,.07);
}

.cd-table th {
  padding: .9rem 1.25rem;
  text-align: left;
  font-size: .68rem; font-weight: 700;
  letter-spacing: .12em; text-transform: uppercase;
  color: var(--smoke);
  white-space: nowrap;
}

.cd-table tbody tr {
  border-bottom: 1px solid rgba(15,31,23,.05);
  transition: background .15s;
}
.cd-table tbody tr:last-child { border-bottom: none; }
.cd-table tbody tr:hover { background: #FAFDF9; }

.cd-table td {
  padding: 1rem 1.25rem;
  vertical-align: middle;
}

/* Ticket pill */
.cd-ticket {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: .72rem; font-weight: 600;
  letter-spacing: .06em;
  color: var(--forest);
  background: var(--mist);
  border: 1px solid rgba(41,82,163,.15);
  padding: .22rem .65rem;
  border-radius: 6px;
  white-space: nowrap;
}

/* Title + category */
.cd-title {
  font-size: .88rem; font-weight: 600;
  color: var(--ink);
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  max-width: 220px;
  margin-bottom: .15rem;
}

.cd-category {
  font-size: .75rem; color: var(--smoke); font-weight: 300;
}

/* Arrondissement */
.cd-arr {
  font-size: .85rem; color: var(--smoke); font-weight: 300;
  white-space: nowrap;
}

/* Status badge */
.cd-badge {
  display: inline-flex; align-items: center; gap: .35rem;
  padding: .3rem .75rem;
  border-radius: 999px;
  font-size: .73rem; font-weight: 600;
  letter-spacing: .03em;
  border: 1.5px solid currentColor;
  white-space: nowrap;
}
.cd-badge--submitted  { color: var(--smoke);  background: rgba(110,125,115,.08); }
.cd-badge--validated  { color: #2563EB;       background: rgba(37,99,235,.07);  }
.cd-badge--in_progress{ color: var(--clay);   background: rgba(201,107,53,.09); }
.cd-badge--resolved   { color: var(--olive);  background: rgba(41,82,163,.09);  }
.cd-badge--archived   { color: #64748B;       background: rgba(100,116,139,.08);}

.cd-badge__dot {
  width: 5px; height: 5px; border-radius: 50%;
  background: currentColor; flex-shrink: 0;
}

/* Date */
.cd-date {
  font-size: .8rem; color: var(--smoke); font-weight: 300;
  white-space: nowrap;
}

/* Action link */
.cd-action {
  display: inline-flex; align-items: center; gap: .3rem;
  font-size: .82rem; font-weight: 600;
  color: var(--olive); text-decoration: none;
  padding: .35rem .75rem; border-radius: 8px;
  border: 1.5px solid rgba(41,82,163,.2);
  transition: background .18s, border-color .18s, color .18s;
  white-space: nowrap;
}
.cd-action:hover {
  background: var(--mist);
  border-color: rgba(41,82,163,.35);
  color: var(--forest);
}

/* Pagination */
.cd-pagination {
  padding: 1.1rem 1.5rem;
  border-top: 1px solid rgba(15,31,23,.06);
  background: var(--mist);
}

/* entrance */
@keyframes cd-up {
  from { opacity: 0; transform: translateY(18px); }
  to   { opacity: 1; transform: translateY(0); }
}
.cd-wrap > * {
  animation: cd-up .6s cubic-bezier(.22,1,.36,1) both;
}
.cd-wrap > *:nth-child(1) { animation-delay: .06s; }
.cd-wrap > *:nth-child(2) { animation-delay: .14s; }
.cd-wrap > *:nth-child(3) { animation-delay: .22s; }
</style>
@endpush

@section('content')

<div class="cd-wrap">

    {{-- ── Header ── --}}
    <div class="cd-header">
        <div>
            <div class="cd-header__greeting">
                <span class="cd-header__greeting-dot"></span>
                Bonjour, {{ explode(' ', auth()->user()->name)[0] }}
            </div>
            <h1 class="cd-header__title">
                Mes <em>signalements</em>
            </h1>
        </div>
        <a href="{{ route('citizen.reports.create') }}" class="cd-btn-new">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Nouveau signalement
        </a>
    </div>

    {{-- ── Stats ── --}}
    <div class="cd-stats">
        <div class="cd-stat" style="--c: var(--ink)">
            <div class="cd-stat__num">{{ $stats['total'] }}</div>
            <div class="cd-stat__label">Total</div>
        </div>
        <div class="cd-stat" style="--c: var(--amber)">
            <div class="cd-stat__num" style="color: var(--amber)">{{ $stats['submitted'] }}</div>
            <div class="cd-stat__label">En attente</div>
        </div>
        <div class="cd-stat" style="--c: var(--clay)">
            <div class="cd-stat__num" style="color: var(--clay)">{{ $stats['in_progress'] }}</div>
            <div class="cd-stat__label">En traitement</div>
        </div>
        <div class="cd-stat" style="--c: var(--olive)">
            <div class="cd-stat__num" style="color: var(--forest)">{{ $stats['resolved'] }}</div>
            <div class="cd-stat__label">Résolus</div>
        </div>
    </div>

    {{-- ── Content ── --}}
    @if($reports->isEmpty())

        {{-- Empty state --}}
        <div class="cd-empty">
            <div class="cd-empty__icon">
                <svg width="32" height="32" fill="none" stroke="currentColor" style="color: var(--smoke)" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3 class="cd-empty__title">Aucun signalement</h3>
            <p class="cd-empty__sub">Vous n'avez pas encore fait de signalement.<br>Contribuez à l'amélioration de votre commune.</p>
            <a href="{{ route('citizen.reports.create') }}" class="cd-btn-new" style="display:inline-flex; margin: 0 auto;">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Faire mon premier signalement
            </a>
        </div>

    @else

        {{-- Table --}}
        <div class="cd-table-card">
            <div class="cd-table-wrap">
                <table class="cd-table">
                    <thead>
                        <tr>
                            <th>Ticket</th>
                            <th>Problème</th>
                            <th>Arrondissement</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                        @php
                            $badgeClass = match($report->status) {
                                'validated'   => 'cd-badge--validated',
                                'in_progress' => 'cd-badge--in_progress',
                                'resolved'    => 'cd-badge--resolved',
                                'archived'    => 'cd-badge--archived',
                                default       => 'cd-badge--submitted',
                            };
                        @endphp
                        <tr>
                            <td>
                                <span class="cd-ticket">{{ $report->ticket_number }}</span>
                            </td>
                            <td>
                                <div class="cd-title">{{ $report->title }}</div>
                                <div class="cd-category">{{ $report->category->name }}</div>
                            </td>
                            <td>
                                <span class="cd-arr">{{ $report->arrondissement->name ?? '—' }}</span>
                            </td>
                            <td>
                                <span class="cd-badge {{ $badgeClass }}">
                                    <span class="cd-badge__dot"></span>
                                    {{ $report->status_label }}
                                </span>
                            </td>
                            <td>
                                <span class="cd-date">{{ $report->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td style="text-align:right">
                                <a href="{{ route('citizen.reports.show', $report) }}" class="cd-action">
                                    Voir
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($reports->hasPages())
            <div class="cd-pagination">
                {{ $reports->links() }}
            </div>
            @endif
        </div>

    @endif

</div>

@endsection