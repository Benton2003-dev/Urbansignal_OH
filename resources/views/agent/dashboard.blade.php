@extends('layouts.app')
@section('title', 'Tableau de bord Agent')

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
.ad-wrap {
  max-width: 1280px;
  margin: 0 auto;
  padding: 2.5rem 2rem 5rem;
}
@media(max-width:640px){ .ad-wrap { padding: 1.75rem 1.25rem 4rem; } }

/* ── Header ── */
.ad-header {
  display: flex; flex-wrap: wrap;
  align-items: flex-start; justify-content: space-between;
  gap: 1.25rem; margin-bottom: 2.5rem;
}

.ad-header__eyebrow {
  font-size: .7rem; font-weight: 600;
  letter-spacing: .16em; text-transform: uppercase;
  color: var(--clay); margin-bottom: .4rem; display: block;
}

.ad-header__title {
  font-family: 'Montserrat', sans-serif;
  font-weight: 900;
  font-size: clamp(1.7rem, 3vw, 2.4rem);
  color: var(--ink); letter-spacing: -.02em; line-height: 1.1;
}
.ad-header__title em { font-style: italic; color: var(--olive); }

.ad-header__sub {
  font-size: .85rem; color: var(--smoke);
  font-weight: 300; margin-top: .3rem;
}

.ad-header__actions { display: flex; gap: .75rem; flex-wrap: wrap; }

.ad-btn {
  display: inline-flex; align-items: center; gap: .45rem;
  font-family: 'Poppins', sans-serif;
  font-weight: 600; font-size: .83rem;
  padding: .65rem 1.25rem; border-radius: 10px;
  text-decoration: none; white-space: nowrap;
  transition: background .18s, transform .18s, box-shadow .18s;
}
.ad-btn--map {
  background: var(--forest); color: #fff;
  box-shadow: 0 4px 16px rgba(27,47,110,.22);
}
.ad-btn--map:hover {
  background: #1a2b62; transform: translateY(-1px);
  box-shadow: 0 8px 24px rgba(27,47,110,.3);
}
.ad-btn--list {
  background: var(--white); color: var(--ink);
  border: 1.5px solid rgba(15,31,23,.12);
}
.ad-btn--list:hover {
  background: var(--mist); border-color: rgba(15,31,23,.2);
}

/* ── KPIs ── */
.ad-kpis {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1px;
  background: rgba(15,31,23,.08);
  border: 1px solid rgba(15,31,23,.08);
  border-radius: 18px;
  overflow: hidden;
  margin-bottom: 2rem;
  box-shadow: 0 6px 24px rgba(15,31,23,.07);
}
@media(min-width:768px){ .ad-kpis { grid-template-columns: repeat(6,1fr); } }

.ad-kpi {
  background: var(--white);
  padding: 1.35rem 1.25rem;
  position: relative;
  transition: background .18s;
}
.ad-kpi:hover { background: var(--mist); }
.ad-kpi::before {
  content: '';
  position: absolute; left: 0; top: 22%; bottom: 22%;
  width: 3px; border-radius: 0 3px 3px 0;
  background: var(--c, var(--smoke));
}

.ad-kpi__num {
  font-family: 'Montserrat', sans-serif;
  font-weight: 700; font-size: 2rem;
  line-height: 1; letter-spacing: -.03em;
  color: var(--ink); margin-bottom: .3rem;
}
.ad-kpi__label {
  font-size: .68rem; font-weight: 600;
  letter-spacing: .08em; text-transform: uppercase;
  color: var(--smoke);
}

/* ── Main grid ── */
.ad-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
  margin-bottom: 1.5rem;
}
@media(min-width:1024px){ .ad-grid { grid-template-columns: 1fr 320px; } }

/* ── Card base ── */
.ad-card {
  background: var(--white);
  border-radius: 20px;
  border: 1px solid rgba(15,31,23,.07);
  box-shadow: 0 6px 28px rgba(15,31,23,.07);
  overflow: hidden;
}

.ad-card__head {
  padding: 1.25rem 1.5rem;
  border-bottom: 1px solid var(--line);
  display: flex; align-items: center; justify-content: space-between;
}

.ad-card__title {
  font-family: 'Montserrat', sans-serif;
  font-weight: 700; font-size: 1.05rem; color: var(--ink);
}

.ad-card__link {
  font-size: .78rem; font-weight: 600;
  color: var(--olive); text-decoration: none;
  display: inline-flex; align-items: center; gap: .25rem;
  transition: color .18s;
}
.ad-card__link:hover { color: var(--forest); }

/* ── Map ── */
#dashboard-map {
  height: 380px;
  border-radius: 0;
}

.ad-map__legend {
  display: flex; flex-wrap: wrap; gap: .75rem 1.25rem;
  padding: 1rem 1.5rem;
  border-top: 1px solid var(--line);
}
.ad-legend-item {
  display: flex; align-items: center; gap: .45rem;
  font-size: .75rem; color: var(--smoke); font-weight: 400;
}
.ad-legend-dot {
  width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0;
}

/* ── Sidebar panels ── */
.ad-sidebar { display: flex; flex-direction: column; gap: 1.5rem; }

.ad-list { padding: 1.25rem 1.5rem; display: flex; flex-direction: column; gap: .65rem; }

.ad-list-row {
  display: flex; align-items: center; justify-content: space-between; gap: .75rem;
}

.ad-list-name {
  font-size: .85rem; color: var(--ink); font-weight: 400;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  flex: 1;
}

.ad-list-bar-wrap {
  display: flex; align-items: center; gap: .65rem; flex-shrink: 0;
}
.ad-list-bar {
  height: 4px; border-radius: 4px;
  background: var(--forest); opacity: .25;
}
.ad-list-count {
  font-family: 'Montserrat', sans-serif;
  font-weight: 700; font-size: .95rem;
  color: var(--ink); min-width: 20px; text-align: right;
}

/* ── Recent reports table ── */
.ad-table-card { margin-top: 0; }

.ad-table-head {
  padding: 1.1rem 1.5rem;
  border-bottom: 1px solid var(--line);
  display: flex; align-items: center; justify-content: space-between;
}

.ad-table-wrap { overflow-x: auto; }

table.ad-table {
  width: 100%; border-collapse: collapse;
}

.ad-table thead {
  background: var(--mist);
  border-bottom: 1px solid var(--line);
}
.ad-table th {
  padding: .8rem 1.25rem;
  text-align: left;
  font-size: .65rem; font-weight: 700;
  letter-spacing: .12em; text-transform: uppercase;
  color: var(--smoke); white-space: nowrap;
}
.ad-table tbody tr {
  border-bottom: 1px solid rgba(15,31,23,.04);
  transition: background .15s;
}
.ad-table tbody tr:last-child { border-bottom: none; }
.ad-table tbody tr:hover { background: #FAFDF9; }
.ad-table td { padding: .9rem 1.25rem; vertical-align: middle; }

/* Ticket */
.ad-ticket {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: .7rem; font-weight: 600; letter-spacing: .05em;
  color: var(--forest); background: var(--mist);
  border: 1px solid rgba(41,82,163,.15);
  padding: .2rem .6rem; border-radius: 6px; white-space: nowrap;
}

/* Title */
.ad-report-title {
  font-size: .86rem; font-weight: 600; color: var(--ink);
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  max-width: 200px; margin-bottom: .12rem;
}
.ad-report-cat {
  font-size: .73rem; color: var(--smoke); font-weight: 300;
}

/* Citizen */
.ad-citizen {
  font-size: .83rem; color: var(--smoke); font-weight: 300;
  white-space: nowrap;
}

/* Priority */
.ad-priority {
  display: inline-flex; align-items: center; gap: .35rem;
  font-size: .73rem; font-weight: 600; letter-spacing: .04em;
  white-space: nowrap;
}
.ad-priority__dot {
  width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0;
  background: currentColor;
}
.ad-priority--urgent { color: #DC2626; }
.ad-priority--high   { color: var(--clay); }
.ad-priority--medium { color: var(--amber); }
.ad-priority--low    { color: var(--olive); }

/* Status badge */
.ad-badge {
  display: inline-flex; align-items: center; gap: .32rem;
  padding: .25rem .7rem;
  border-radius: 999px;
  font-size: .7rem; font-weight: 600; letter-spacing: .03em;
  border: 1.5px solid currentColor; white-space: nowrap;
}
.ad-badge__dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; flex-shrink: 0; }
.ad-badge--submitted  { color: var(--smoke);  background: rgba(110,125,115,.08); }
.ad-badge--validated  { color: #2563EB;       background: rgba(37,99,235,.07);  }
.ad-badge--in_progress{ color: var(--clay);   background: rgba(201,107,53,.09); }
.ad-badge--resolved   { color: var(--olive);  background: rgba(41,82,163,.09);  }
.ad-badge--archived   { color: #64748B;       background: rgba(100,116,139,.08);}

/* Action */
.ad-action {
  display: inline-flex; align-items: center; gap: .3rem;
  font-size: .78rem; font-weight: 600; color: var(--olive);
  text-decoration: none;
  padding: .3rem .7rem; border-radius: 7px;
  border: 1.5px solid rgba(41,82,163,.2);
  transition: background .15s, border-color .15s, color .15s;
  white-space: nowrap;
}
.ad-action:hover {
  background: var(--mist);
  border-color: rgba(41,82,163,.35);
  color: var(--forest);
}

/* entrance */
@keyframes ad-up {
  from { opacity: 0; transform: translateY(16px); }
  to   { opacity: 1; transform: translateY(0); }
}
.ad-wrap > * {
  animation: ad-up .55s cubic-bezier(.22,1,.36,1) both;
}
.ad-wrap > *:nth-child(1){ animation-delay: .05s; }
.ad-wrap > *:nth-child(2){ animation-delay: .12s; }
.ad-wrap > *:nth-child(3){ animation-delay: .19s; }
.ad-wrap > *:nth-child(4){ animation-delay: .26s; }
</style>
@endpush

@section('content')

<div class="ad-wrap">

    {{-- ── Header ── --}}
    <div class="ad-header">
        <div>
            <span class="ad-header__eyebrow">Secrétariat exécutif</span>
            <h1 class="ad-header__title">Tableau de bord <em>Agent</em></h1>
            <p class="ad-header__sub">Bonjour, {{ auth()->user()->name }}</p>
        </div>
        <div class="ad-header__actions">
            <a href="{{ route('agent.reports.map') }}" class="ad-btn ad-btn--map">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
                Carte complète
            </a>
            <a href="{{ route('agent.reports.index') }}" class="ad-btn ad-btn--list">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                Tous les signalements
            </a>
        </div>
    </div>

    {{-- ── KPIs ── --}}
    <div class="ad-kpis">
        <div class="ad-kpi" style="--c: var(--ink)">
            <div class="ad-kpi__num">{{ $stats['total'] }}</div>
            <div class="ad-kpi__label">Total</div>
        </div>
        <div class="ad-kpi" style="--c: var(--smoke)">
            <div class="ad-kpi__num" style="color: var(--smoke)">{{ $stats['submitted'] }}</div>
            <div class="ad-kpi__label">Soumis</div>
        </div>
        <div class="ad-kpi" style="--c: #2563EB">
            <div class="ad-kpi__num" style="color: #2563EB">{{ $stats['validated'] }}</div>
            <div class="ad-kpi__label">Validés</div>
        </div>
        <div class="ad-kpi" style="--c: var(--clay)">
            <div class="ad-kpi__num" style="color: var(--clay)">{{ $stats['in_progress'] }}</div>
            <div class="ad-kpi__label">En cours</div>
        </div>
        <div class="ad-kpi" style="--c: var(--olive)">
            <div class="ad-kpi__num" style="color: var(--forest)">{{ $stats['resolved'] }}</div>
            <div class="ad-kpi__label">Résolus</div>
        </div>
        <div class="ad-kpi" style="--c: #DC2626">
            <div class="ad-kpi__num" style="color: #DC2626">{{ $stats['urgent'] }}</div>
            <div class="ad-kpi__label">Urgents</div>
        </div>
    </div>

    {{-- ── Map + Sidebar ── --}}
    <div class="ad-grid">

        {{-- Map --}}
        <div class="ad-card">
            <div class="ad-card__head">
                <span class="ad-card__title">Carte des signalements</span>
                <a href="{{ route('agent.reports.map') }}" class="ad-card__link">
                    Plein écran
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div id="dashboard-map"></div>
            <div class="ad-map__legend">
                <span class="ad-legend-item"><span class="ad-legend-dot" style="background:#DC2626"></span>Urgent</span>
                <span class="ad-legend-item"><span class="ad-legend-dot" style="background:#F97316"></span>Élevé</span>
                <span class="ad-legend-item"><span class="ad-legend-dot" style="background:#EAB308"></span>Moyen</span>
                <span class="ad-legend-item"><span class="ad-legend-dot" style="background:#22C55E"></span>Faible</span>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="ad-sidebar">

            {{-- By arrondissement --}}
            <div class="ad-card">
                <div class="ad-card__head">
                    <span class="ad-card__title">Par arrondissement</span>
                </div>
                <div class="ad-list">
                    @foreach($arrondissements->sortByDesc('reports_count')->take(6) as $arr)
                    <div class="ad-list-row">
                        <span class="ad-list-name">{{ $arr->name }}</span>
                        <div class="ad-list-bar-wrap">
                            <div class="ad-list-bar" style="width: {{ $arr->reports_count > 0 ? min($arr->reports_count * 10, 80) : 4 }}px; opacity: {{ $arr->reports_count > 0 ? min(0.15 + $arr->reports_count * 0.05, 0.7) : 0.1 }}"></div>
                            <span class="ad-list-count">{{ $arr->reports_count }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- By category --}}
            <div class="ad-card">
                <div class="ad-card__head">
                    <span class="ad-card__title">Par catégorie</span>
                </div>
                <div class="ad-list">
                    @foreach($categories->sortByDesc('reports_count')->take(5) as $cat)
                    <div class="ad-list-row">
                        <span class="ad-list-name">{{ $cat->name }}</span>
                        <div class="ad-list-bar-wrap">
                            <div class="ad-list-bar" style="width: {{ $cat->reports_count > 0 ? min($cat->reports_count * 10, 80) : 4 }}px; opacity: {{ $cat->reports_count > 0 ? min(0.15 + $cat->reports_count * 0.05, 0.7) : 0.1 }}"></div>
                            <span class="ad-list-count">{{ $cat->reports_count }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    {{-- ── Recent reports ── --}}
    <div class="ad-card ad-table-card">
        <div class="ad-table-head">
            <span class="ad-card__title">Signalements récents</span>
            <a href="{{ route('agent.reports.index') }}" class="ad-card__link">
                Voir tous
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="ad-table-wrap">
            <table class="ad-table">
                <thead>
                    <tr>
                        <th>Ticket</th>
                        <th>Problème</th>
                        <th>Citoyen</th>
                        <th>Arrondissement</th>
                        <th>Priorité</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentReports as $report)
                    @php
                        $badgeClass = match($report->status) {
                            'validated'   => 'ad-badge--validated',
                            'in_progress' => 'ad-badge--in_progress',
                            'resolved'    => 'ad-badge--resolved',
                            'archived'    => 'ad-badge--archived',
                            default       => 'ad-badge--submitted',
                        };
                        $priorityClass = match($report->priority) {
                            'urgent' => 'ad-priority--urgent',
                            'high'   => 'ad-priority--high',
                            'medium' => 'ad-priority--medium',
                            default  => 'ad-priority--low',
                        };
                    @endphp
                    <tr>
                        <td><span class="ad-ticket">{{ $report->ticket_number }}</span></td>
                        <td>
                            <div class="ad-report-title">{{ $report->title }}</div>
                            <div class="ad-report-cat">{{ $report->category->name }}</div>
                        </td>
                        <td><span class="ad-citizen">{{ $report->user->name }}</span></td>
                        <td><span class="ad-citizen">{{ $report->arrondissement->name ?? '—' }}</span></td>
                        <td>
                            <span class="ad-priority {{ $priorityClass }}">
                                <span class="ad-priority__dot"></span>
                                {{ $report->priority_label }}
                            </span>
                        </td>
                        <td>
                            <span class="ad-badge {{ $badgeClass }}">
                                <span class="ad-badge__dot"></span>
                                {{ $report->status_label }}
                            </span>
                        </td>
                        <td style="text-align:right">
                            <a href="{{ route('agent.reports.show', $report) }}" class="ad-action">
                                Gérer
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
window.addEventListener('load', function () {
    const map = L.map('dashboard-map').setView([6.3622, 2.0852], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap', maxZoom: 19
    }).addTo(map);

    setTimeout(() => map.invalidateSize(), 200);

    const clusters = L.markerClusterGroup();

    const priorityColors = {
        urgent: '#DC2626',
        high:   '#F97316',
        medium: '#EAB308',
        low:    '#22C55E'
    };

    const reports = @json($mapReports);

    reports.forEach(r => {
        if (!r.latitude || !r.longitude) return;
        const color = priorityColors[r.priority] || '#6E7D73';
        const icon = L.divIcon({
            className: '',
            html: `<div style="
                background: ${color};
                width: 13px; height: 13px;
                border-radius: 50%;
                border: 2.5px solid white;
                box-shadow: 0 1px 6px rgba(0,0,0,.35)
            "></div>`,
            iconSize: [13, 13],
            iconAnchor: [6, 6]
        });

        const marker = L.marker([r.latitude, r.longitude], { icon })
            .bindPopup(`
                <div style="font-family: 'Poppins', sans-serif; min-width: 160px;">
                    <div style="font-size:.7rem; font-weight:600; letter-spacing:.08em; text-transform:uppercase; color:#6E7D73; margin-bottom:.2rem;">${r.ticket_number}</div>
                    <div style="font-size:.88rem; font-weight:600; color:#0F1F17; margin-bottom:.3rem;">${r.title}</div>
                    <div style="font-size:.75rem; color:#6E7D73;">${r.status}</div>
                </div>
            `)
            .on('click', () => window.location.href = '/agent/signalements/' + r.id);

        clusters.addLayer(marker);
    });

    map.addLayer(clusters);
});
</script>
@endpush