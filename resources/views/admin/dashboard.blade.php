@extends('layouts.app')
@section('title', 'Tableau de bord Admin')

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

/* ── Wrapper ── */
.adb-wrap {
  max-width: 1280px;
  margin: 0 auto;
  padding: 2.5rem 2rem 5rem;
}
@media(max-width:640px){ .adb-wrap { padding: 1.75rem 1.25rem 4rem; } }

/* entrance */
@keyframes adb-up {
  from { opacity: 0; transform: translateY(16px); }
  to   { opacity: 1; transform: translateY(0); }
}
.adb-wrap > * {
  animation: adb-up .55s cubic-bezier(.22,1,.36,1) both;
}
.adb-wrap > *:nth-child(1){ animation-delay: .05s; }
.adb-wrap > *:nth-child(2){ animation-delay: .12s; }
.adb-wrap > *:nth-child(3){ animation-delay: .19s; }
.adb-wrap > *:nth-child(4){ animation-delay: .26s; }
.adb-wrap > *:nth-child(5){ animation-delay: .33s; }

/* ── Header ── */
.adb-header {
  display: flex; flex-wrap: wrap;
  align-items: flex-start; justify-content: space-between;
  gap: 1.25rem; margin-bottom: 2.5rem;
}

.adb-header__eyebrow {
  font-size: .7rem; font-weight: 600;
  letter-spacing: .16em; text-transform: uppercase;
  color: var(--clay); margin-bottom: .4rem; display: block;
}

.adb-header__title {
  font-family: 'Montserrat', sans-serif;
  font-weight: 900;
  font-size: clamp(1.7rem, 3vw, 2.4rem);
  color: var(--ink); letter-spacing: -.02em; line-height: 1.1;
}
.adb-header__title em { font-style: italic; color: var(--olive); }

.adb-header__sub {
  font-size: .85rem; color: var(--smoke); font-weight: 300; margin-top: .3rem;
}

.adb-btn-stats {
  display: inline-flex; align-items: center; gap: .5rem;
  background: var(--clay); color: #fff;
  font-family: 'Poppins', sans-serif;
  font-weight: 600; font-size: .83rem;
  padding: .68rem 1.35rem; border-radius: 10px;
  text-decoration: none; flex-shrink: 0;
  box-shadow: 0 4px 18px rgba(201,107,53,.3);
  transition: background .18s, transform .18s, box-shadow .18s;
}
.adb-btn-stats:hover {
  background: #D97840; transform: translateY(-1px);
  box-shadow: 0 8px 24px rgba(201,107,53,.38);
}

/* ── KPIs ── */
.adb-kpis {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1px;
  background: rgba(15,31,23,.08);
  border: 1px solid rgba(15,31,23,.08);
  border-radius: 18px;
  overflow: hidden;
  margin-bottom: 2rem;
  box-shadow: 0 6px 28px rgba(15,31,23,.07);
}
@media(min-width:768px){ .adb-kpis { grid-template-columns: repeat(6,1fr); } }

.adb-kpi {
  background: var(--white);
  padding: 1.5rem 1.25rem 1.35rem;
  position: relative;
  transition: background .18s;
}
.adb-kpi:hover { background: var(--mist); }
.adb-kpi::before {
  content: '';
  position: absolute; left: 0; top: 22%; bottom: 22%;
  width: 3px; border-radius: 0 3px 3px 0;
  background: var(--c, var(--smoke));
}

.adb-kpi__icon {
  width: 28px; height: 28px; margin-bottom: .6rem;
  color: var(--ic, var(--smoke));
}

.adb-kpi__num {
  font-family: 'Montserrat', sans-serif;
  font-weight: 700; font-size: 2rem;
  line-height: 1; letter-spacing: -.03em;
  color: var(--ink); margin-bottom: .28rem;
}

.adb-kpi__label {
  font-size: .67rem; font-weight: 600;
  letter-spacing: .08em; text-transform: uppercase;
  color: var(--smoke); line-height: 1.3;
}

/* ── 2-col charts grid ── */
.adb-charts {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
  margin-bottom: 1.5rem;
}
@media(min-width:768px){ .adb-charts { grid-template-columns: 1fr 1fr; } }

/* ── Card ── */
.adb-card {
  background: var(--white);
  border-radius: 20px;
  border: 1px solid rgba(15,31,23,.07);
  box-shadow: 0 6px 28px rgba(15,31,23,.07);
  overflow: hidden;
}

.adb-card__head {
  padding: 1.25rem 1.5rem;
  border-bottom: 1px solid var(--line);
}

.adb-card__title {
  font-family: 'Montserrat', sans-serif;
  font-weight: 700; font-size: 1.05rem; color: var(--ink);
}

.adb-card__body { padding: 1.5rem; }

/* ── Progress bars ── */
.adb-bars { display: flex; flex-direction: column; gap: 1rem; }

.adb-bar-row { }

.adb-bar-meta {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: .4rem;
}

.adb-bar-label {
  font-size: .85rem; color: var(--ink); font-weight: 400;
}

.adb-bar-count {
  display: flex; align-items: baseline; gap: .35rem;
}
.adb-bar-count__num {
  font-family: 'Montserrat', sans-serif;
  font-weight: 700; font-size: .95rem; color: var(--ink);
}
.adb-bar-count__pct {
  font-size: .72rem; color: var(--smoke); font-weight: 300;
}

.adb-bar-track {
  height: 5px; background: rgba(15,31,23,.07);
  border-radius: 999px; overflow: hidden;
}
.adb-bar-fill {
  height: 100%; border-radius: 999px;
  transition: width .6s cubic-bezier(.22,1,.36,1);
}

/* ── Quick links ── */
.adb-links {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
}
@media(min-width:768px){ .adb-links { grid-template-columns: repeat(4, 1fr); } }

.adb-link-card {
  background: var(--white);
  border: 1.5px solid rgba(15,31,23,.07);
  border-radius: 18px;
  padding: 1.5rem 1.25rem;
  text-decoration: none;
  display: block;
  position: relative;
  overflow: hidden;
  transition: transform .22s cubic-bezier(.22,1,.36,1), box-shadow .22s, border-color .18s;
}
.adb-link-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 16px 40px rgba(15,31,23,.1);
  border-color: var(--hc, rgba(15,31,23,.15));
}

/* ghost number */
.adb-link-card::after {
  content: attr(data-num);
  position: absolute; bottom: -.8rem; right: .5rem;
  font-family: 'Montserrat', sans-serif;
  font-size: 5rem; font-weight: 900;
  color: rgba(15,31,23,.04);
  line-height: 1; pointer-events: none; user-select: none;
}

.adb-link-card__icon {
  width: 42px; height: 42px; border-radius: 12px;
  background: var(--mist);
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 1.1rem;
  transition: background .22s;
}
.adb-link-card:hover .adb-link-card__icon { background: var(--ic, var(--forest)); }
.adb-link-card:hover .adb-link-card__icon svg { color: #fff !important; }

.adb-link-card__title {
  font-family: 'Montserrat', sans-serif;
  font-weight: 700; font-size: .98rem; color: var(--ink);
  margin-bottom: .3rem;
}

.adb-link-card__sub {
  font-size: .78rem; color: var(--smoke); font-weight: 300; line-height: 1.4;
}
</style>
@endpush

@section('content')

<div class="adb-wrap">

    {{-- ── Header ── --}}
    <div class="adb-header">
        <div>
            <span class="adb-header__eyebrow">UrbanSignal — Ouidah</span>
            <h1 class="adb-header__title">Tableau de bord <em>Admin</em></h1>
            <p class="adb-header__sub">Vue d'ensemble de la plateforme</p>
        </div>
        <a href="{{ route('admin.reports.statistics') }}" class="adb-btn-stats">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Statistiques détaillées
        </a>
    </div>

    {{-- ── KPIs ── --}}
    <div class="adb-kpis">
        <div class="adb-kpi" style="--c: var(--ink)">
            <div class="adb-kpi__icon" style="color: var(--smoke)">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div class="adb-kpi__num">{{ $stats['total_reports'] }}</div>
            <div class="adb-kpi__label">Total signalements</div>
        </div>
        <div class="adb-kpi" style="--c: #2563EB">
            <div class="adb-kpi__icon" style="color: #2563EB">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div class="adb-kpi__num" style="color: #2563EB">{{ $stats['total_citizens'] }}</div>
            <div class="adb-kpi__label">Citoyens</div>
        </div>
        <div class="adb-kpi" style="--c: var(--clay)">
            <div class="adb-kpi__icon" style="color: var(--clay)">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div class="adb-kpi__num" style="color: var(--clay)">{{ $stats['total_agents'] }}</div>
            <div class="adb-kpi__label">Agents</div>
        </div>
        <div class="adb-kpi" style="--c: var(--olive)">
            <div class="adb-kpi__icon" style="color: var(--olive)">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="adb-kpi__num" style="color: var(--forest)">{{ $stats['resolved'] }}</div>
            <div class="adb-kpi__label">Résolus</div>
        </div>
        <div class="adb-kpi" style="--c: var(--amber)">
            <div class="adb-kpi__icon" style="color: var(--amber)">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="adb-kpi__num" style="color: var(--amber)">{{ $stats['pending'] }}</div>
            <div class="adb-kpi__label">En attente</div>
        </div>
        <div class="adb-kpi" style="--c: var(--forest)">
            <div class="adb-kpi__icon" style="color: var(--forest)">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div class="adb-kpi__num" style="color: var(--forest)">{{ $stats['this_month'] }}</div>
            <div class="adb-kpi__label">Ce mois-ci</div>
        </div>
    </div>

    {{-- ── Charts row ── --}}
    <div class="adb-charts">

        {{-- Status distribution --}}
        @php
            $statusLabels = ['submitted'=>'Soumis','validated'=>'Validé','in_progress'=>'En cours','resolved'=>'Résolu','archived'=>'Archivé'];
            $statusFills  = [
                'submitted'   => 'rgba(110,125,115,.55)',
                'validated'   => '#2563EB',
                'in_progress' => 'var(--clay)',
                'resolved'    => 'var(--olive)',
                'archived'    => '#94A3B8',
            ];
            $total = $byStatus->sum();
        @endphp
        <div class="adb-card">
            <div class="adb-card__head">
                <div class="adb-card__title">Répartition par statut</div>
            </div>
            <div class="adb-card__body">
                <div class="adb-bars">
                    @foreach($statusLabels as $key => $label)
                    @php
                        $count = $byStatus[$key] ?? 0;
                        $pct   = $total > 0 ? round($count / $total * 100) : 0;
                        $fill  = $statusFills[$key] ?? 'var(--smoke)';
                    @endphp
                    <div class="adb-bar-row">
                        <div class="adb-bar-meta">
                            <span class="adb-bar-label">{{ $label }}</span>
                            <div class="adb-bar-count">
                                <span class="adb-bar-count__num">{{ $count }}</span>
                                <span class="adb-bar-count__pct">{{ $pct }}%</span>
                            </div>
                        </div>
                        <div class="adb-bar-track">
                            <div class="adb-bar-fill" style="width: {{ $pct }}%; background: {{ $fill }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Top categories --}}
        @php $maxCat = $byCategory->max('reports_count') ?: 1; @endphp
        <div class="adb-card">
            <div class="adb-card__head">
                <div class="adb-card__title">Top catégories</div>
            </div>
            <div class="adb-card__body">
                <div class="adb-bars">
                    @foreach($byCategory as $cat)
                    @php $pct = round($cat->reports_count / $maxCat * 100); @endphp
                    <div class="adb-bar-row">
                        <div class="adb-bar-meta">
                            <span class="adb-bar-label" style="max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap">{{ $cat->name }}</span>
                            <div class="adb-bar-count">
                                <span class="adb-bar-count__num">{{ $cat->reports_count }}</span>
                            </div>
                        </div>
                        <div class="adb-bar-track">
                            <div class="adb-bar-fill" style="width: {{ $pct }}%; background: {{ $cat->color ?? 'var(--olive)' }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- ── Quick links ── --}}
    <div class="adb-links">

        <a href="{{ route('admin.users.index') }}" class="adb-link-card" data-num="01" style="--hc: rgba(37,99,235,.2); --ic: #2563EB">
            <div class="adb-link-card__icon">
                <svg width="20" height="20" fill="none" stroke="currentColor" style="color: var(--forest)" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="adb-link-card__title">Utilisateurs</div>
            <div class="adb-link-card__sub">Citoyens, agents, admins</div>
        </a>

        <a href="{{ route('admin.categories.index') }}" class="adb-link-card" data-num="02" style="--hc: rgba(41,82,163,.2); --ic: var(--olive)">
            <div class="adb-link-card__icon">
                <svg width="20" height="20" fill="none" stroke="currentColor" style="color: var(--forest)" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <div class="adb-link-card__title">Catégories</div>
            <div class="adb-link-card__sub">Types de dégradations</div>
        </a>

        <a href="{{ route('admin.reports.index') }}" class="adb-link-card" data-num="03" style="--hc: rgba(201,107,53,.2); --ic: var(--clay)">
            <div class="adb-link-card__icon">
                <svg width="20" height="20" fill="none" stroke="currentColor" style="color: var(--forest)" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div class="adb-link-card__title">Signalements</div>
            <div class="adb-link-card__sub">Voir et filtrer tous les rapports</div>
        </a>

        <a href="{{ route('admin.reports.statistics') }}" class="adb-link-card" data-num="04" style="--hc: rgba(229,160,58,.2); --ic: var(--amber)">
            <div class="adb-link-card__icon">
                <svg width="20" height="20" fill="none" stroke="currentColor" style="color: var(--forest)" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div class="adb-link-card__title">Statistiques</div>
            <div class="adb-link-card__sub">Rapports & analyses</div>
        </a>

    </div>

</div>

@endsection