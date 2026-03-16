@extends('layouts.app')
@section('title', 'Carte des signalements')

@push('styles')
<style>
#fullmap { height: calc(100vh - 80px); }
#sidebar { position: absolute; right: 10px; top: 10px; z-index: 1000; width: 300px; max-height: calc(100vh - 120px); overflow-y: auto; }
</style>
@endpush

@section('content')
<div class="relative">
    <div id="fullmap"></div>

    {{-- Floating sidebar --}}
    <div id="sidebar" class="bg-white rounded-2xl shadow-xl border border-gray-100 p-4">
        <h2 class="font-semibold text-gray-900 mb-3 text-sm">Carte des signalements</h2>

        {{-- Total --}}
        <div class="mb-3 text-xs text-gray-500">
            <span class="font-bold text-gray-800 text-sm" id="countVisible">0</span> signalement(s) affiché(s)
            @if($reports->isEmpty())
            <div class="mt-2 p-2 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-700">
                Aucun signalement avec coordonnées GPS pour le moment. Les signalements apparaîtront ici dès que les citoyens indiqueront leur position.
            </div>
            @endif
        </div>

        {{-- Filters --}}
        <div class="space-y-2 mb-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Filtrer par statut</label>
                <select id="filterStatus" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-400 bg-white">
                    <option value="">— Tous les statuts —</option>
                    @foreach(['submitted'=>'Soumis','validated'=>'Validé','in_progress'=>'En cours','resolved'=>'Résolu'] as $v => $l)
                    <option value="{{ $v }}">{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Filtrer par priorité</label>
                <select id="filterPriority" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-400 bg-white">
                    <option value="">— Toutes priorités —</option>
                    @foreach(['urgent'=>'Urgent','high'=>'Élevé','medium'=>'Moyen','low'=>'Faible'] as $v => $l)
                    <option value="{{ $v }}">{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <button onclick="resetFilters()" class="w-full text-xs text-gray-500 hover:text-gray-700 underline text-left transition">
                Réinitialiser les filtres
            </button>
        </div>

        {{-- Legend --}}
        <div class="border-t border-gray-100 pt-3 mb-4">
            <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Légende — Priorité</p>
            <div class="grid grid-cols-2 gap-1 text-xs text-gray-600">
                <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-red-500 inline-block flex-shrink-0"></span> Urgent</div>
                <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-orange-500 inline-block flex-shrink-0"></span> Élevé</div>
                <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-yellow-400 inline-block flex-shrink-0"></span> Moyen</div>
                <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-green-500 inline-block flex-shrink-0"></span> Faible</div>
            </div>
        </div>

        {{-- Report list --}}
        <div class="border-t border-gray-100 pt-3">
            <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Liste</p>
            <div id="reportList" style="max-height: 35vh; overflow-y: auto;" class="space-y-2">
                <p id="emptyMsg" class="text-xs text-gray-400 italic">Aucun résultat pour ces filtres.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
window.addEventListener('load', function () {
const map = L.map('fullmap').setView([6.3622, 2.0852], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© <a href="https://www.openstreetmap.org">OpenStreetMap</a>', maxZoom: 19
}).addTo(map);
setTimeout(() => map.invalidateSize(), 200);

const priorityColors = { urgent: '#EF4444', high: '#F97316', medium: '#EAB308', low: '#22C55E' };
const statusLabels = { submitted: 'Soumis', validated: 'Validé', in_progress: 'En cours', resolved: 'Résolu', archived: 'Archivé' };

const allReports = @json($reports);
let markers = [];
let clusterGroup = L.markerClusterGroup({ chunkedLoading: true });
map.addLayer(clusterGroup);

function makeIcon(priority) {
    const color = priorityColors[priority] || '#6B7280';
    return L.divIcon({
        className: '',
        html: `<div style="background:${color};width:14px;height:14px;border-radius:50%;border:2.5px solid white;box-shadow:0 2px 6px rgba(0,0,0,0.4)"></div>`,
        iconSize: [14, 14], iconAnchor: [7, 7]
    });
}

function renderMarkers() {
    const fStatus   = document.getElementById('filterStatus').value;
    const fPriority = document.getElementById('filterPriority').value;

    clusterGroup.clearLayers();
    markers = [];

    const list = document.getElementById('reportList');
    // Vider sauf le message vide
    Array.from(list.children).forEach(c => { if (c.id !== 'emptyMsg') c.remove(); });

    const filtered = allReports.filter(r => {
        if (!r.latitude || !r.longitude) return false;
        if (fStatus   && r.status   !== fStatus)   return false;
        if (fPriority && r.priority !== fPriority) return false;
        return true;
    });

    document.getElementById('countVisible').textContent = filtered.length;

    const emptyMsg = document.getElementById('emptyMsg');
    if (filtered.length === 0) {
        emptyMsg.style.display = 'block';
        emptyMsg.textContent = allReports.length === 0
            ? 'Aucun signalement avec position GPS. Les signalements apparaîtront dès que des citoyens indiqueront leur localisation.'
            : 'Aucun résultat pour ces filtres.';
    } else {
        emptyMsg.style.display = 'none';
    }

    const statusBadgeColors = {
        submitted:   '#6B7280',
        validated:   '#3B82F6',
        in_progress: '#D97706',
        resolved:    '#16A34A',
        archived:    '#94A3B8'
    };

    filtered.forEach(r => {
        const lat = parseFloat(r.latitude);
        const lng = parseFloat(r.longitude);
        const m   = L.marker([lat, lng], { icon: makeIcon(r.priority) });

        m.bindPopup(`
            <div style="min-width:210px;font-family:system-ui,sans-serif">
                <p style="font-family:monospace;font-size:10px;color:#9CA3AF;margin:0 0 2px">${r.ticket_number}</p>
                <p style="font-weight:700;font-size:13px;margin:0 0 4px;color:#111">${r.title}</p>
                <span style="display:inline-block;padding:2px 8px;border-radius:12px;font-size:11px;font-weight:600;background:${statusBadgeColors[r.status] || '#6B7280'}22;color:${statusBadgeColors[r.status] || '#6B7280'}">${statusLabels[r.status] || r.status}</span>
                <a href="/agent/signalements/${r.id}" style="display:block;margin-top:10px;padding:6px 12px;background:#16a34a;color:white;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;text-align:center">
                    Gérer ce signalement →
                </a>
            </div>
        `);
        clusterGroup.addLayer(m);
        markers.push({ report: r, marker: m });

        // Item dans la liste latérale
        const item = document.createElement('div');
        item.className = 'p-2 rounded-lg border border-gray-100 hover:bg-green-50 cursor-pointer transition text-left';
        item.innerHTML = `
            <div style="display:flex;align-items:center;gap:6px;margin-bottom:2px">
                <span style="width:8px;height:8px;border-radius:50%;background:${priorityColors[r.priority]||'#6B7280'};flex-shrink:0;display:inline-block"></span>
                <span style="font-family:monospace;font-size:10px;color:#9CA3AF">${r.ticket_number}</span>
            </div>
            <p style="font-size:11px;font-weight:600;color:#374151;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${r.title}</p>
            <p style="font-size:10px;color:#6B7280;margin:0">${statusLabels[r.status] || r.status}</p>
        `;
        item.addEventListener('click', () => {
            map.setView([lat, lng], 17);
            m.openPopup();
        });
        list.appendChild(item);
    });
}

function resetFilters() {
    document.getElementById('filterStatus').value   = '';
    document.getElementById('filterPriority').value = '';
    renderMarkers();
}

document.getElementById('filterStatus').addEventListener('change', renderMarkers);
document.getElementById('filterPriority').addEventListener('change', renderMarkers);
renderMarkers();
}); // end window.addEventListener('load')
</script>
@endpush
