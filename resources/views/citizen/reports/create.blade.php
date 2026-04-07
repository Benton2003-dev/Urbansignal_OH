@extends('layouts.app')
@section('title', 'Nouveau signalement')

@push('styles')
<style>
#map { height: 350px; border-radius: 12px; }
.step-indicator { transition: all 0.3s ease; }
.photo-preview { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px; }
.photo-preview img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb; }
</style>
@endpush

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <a href="{{ route('citizen.dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Retour
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Nouveau signalement</h1>
        <p class="text-gray-500 text-sm mt-1">Signalez un problème dans votre quartier (voirie, eau, électricité, assainissement…)</p>
    </div>

    {{-- Step indicators --}}
    <div class="flex items-center mb-8" id="steps">
        @php $stepLabels = ['Domaine & Catégorie', 'Localisation', 'Photos', 'Description']; @endphp
        @foreach($stepLabels as $i => $label)
        <div class="flex items-center {{ $loop->last ? '' : 'flex-1' }}">
            <div class="step-indicator flex items-center justify-center w-8 h-8 rounded-full text-sm font-bold
                {{ $i === 0 ? 'bg-blue-700 text-green' : 'bg-gray-200 text-gray-400' }}" id="step-badge-{{ $i }}">
                {{ $i + 1 }}
            </div>
            <span class="ml-2 text-sm font-medium {{ $i === 0 ? 'text-blue-700' : 'text-gray-400' }}" id="step-label-{{ $i }}">{{ $label }}</span>
            @if(!$loop->last)
            <div class="flex-1 h-0.5 bg-gray-200 mx-3" id="step-line-{{ $i }}"></div>
            @endif
        </div>
        @endforeach
    </div>

    {{-- Errors --}}
    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
        <ul class="text-red-700 text-sm space-y-1 list-disc list-inside">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('citizen.reports.store') }}" method="POST" enctype="multipart/form-data" id="report-form">
        @csrf

        {{-- ─── STEP 1: Domaine + Catégorie ──────────────────────────────── --}}
        <div id="step-0" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

            {{-- Champs cachés --}}
            <input type="hidden" name="domain_id" id="domain_id" value="{{ old('domain_id') }}">
            <input type="hidden" name="category_id" id="category_id" value="{{ old('category_id') }}">

            {{-- 1a. Choix du domaine --}}
            <h2 class="text-lg font-semibold text-gray-900 mb-1">Quel service est concerné ?</h2>
            <p class="text-sm text-gray-500 mb-4">Choisissez le domaine correspondant à votre problème.</p>

            <div class="grid grid-cols-2 gap-3 mb-6" id="domain-cards">
                @foreach($domains as $domain)
                <button type="button" onclick="selectDomain({{ $domain->id }}, '{{ $domain->name }}', '{{ $domain->color }}')"
                        id="domain-card-{{ $domain->id }}"
                        class="domain-card p-4 border-2 border-gray-200 rounded-xl text-left hover:border-gray-300 transition {{ old('domain_id') == $domain->id ? 'border-blue-500 bg-green-50' : '' }}">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background-color: {{ $domain->color }}20">
                            <div class="w-4 h-4 rounded-full" style="background-color: {{ $domain->color }}"></div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $domain->name }}</p>
                            @if($domain->description)
                            <p class="text-xs text-gray-400 leading-tight mt-0.5">{{ Str::limit($domain->description, 40) }}</p>
                            @endif
                        </div>
                    </div>
                </button>
                @endforeach
            </div>

            {{-- 1b. Catégories (chargées dynamiquement) --}}
            <div id="category-section" class="{{ old('domain_id') ? '' : 'hidden' }}">
                <div class="border-t border-gray-100 pt-5 mb-4">
                    <h3 class="text-base font-semibold text-gray-900 mb-1">Quel type de problème ?</h3>
                    <p class="text-sm text-gray-500 mb-3" id="category-subtitle">Sélectionnez la catégorie correspondante.</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-3" id="category-grid">
                    {{-- Chargé dynamiquement via JS --}}
                </div>

                <div id="category-loading" class="hidden py-8 text-center">
                    <svg class="w-6 h-6 animate-spin text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <p class="text-sm text-gray-400 mt-2">Chargement des catégories…</p>
                </div>
            </div>

            {{-- Arrondissement --}}
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Arrondissement <span class="text-red-500">*</span></label>
                <select name="arrondissement_id" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900">
                    <option value="">Sélectionnez un arrondissement</option>
                    @foreach($arrondissements as $arr)
                    <option value="{{ $arr->id }}" {{ old('arrondissement_id') == $arr->id ? 'selected' : '' }}>{{ $arr->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" onclick="nextStep(0)" class="px-6 py-2.5 bg-blue-700 text-green font-semibold rounded-xl hover:bg-blue-800 transition">
                    Suivant →
                </button>
            </div>
        </div>

        {{-- ─── STEP 2: Location ─────────────────────────────────────────── --}}
        <div id="step-1" class="hidden bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Localisation du problème</h2>
            <p class="text-sm text-gray-500 mb-4">Cliquez sur le bouton GPS ou directement sur la carte pour indiquer l'emplacement.</p>

            {{-- GPS button --}}
            <button type="button" id="geoBtn"
                    class="w-full flex items-center justify-center gap-2 px-4 py-3 border-2 border-dashed border-green-300 text-blue-700 rounded-xl hover:bg-blue-50 transition mb-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span id="geoBtnText" class="flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Détecter ma position GPS automatiquement
                </span>
            </button>

            {{-- GPS permission notice --}}
            <div id="geoNotice" class="hidden mb-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-sm text-yellow-800">
                <span class="flex items-start gap-2">
                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span><strong>Permission requise :</strong> Votre navigateur va demander l'autorisation d'accéder à votre position. Cliquez sur <strong>"Autoriser"</strong> dans la barre du navigateur.</span>
                </span>
            </div>

            {{-- GPS error --}}
            <div id="geoError" class="hidden mb-3 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700"></div>

            {{-- Map --}}
            <div id="map" class="mb-3 border border-gray-200 rounded-xl"></div>
            <p class="text-xs text-gray-400 mb-4 flex items-start gap-1.5">
                <svg class="w-3.5 h-3.5 flex-shrink-0 mt-0.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span><strong>Astuce :</strong> Cliquez n'importe où sur la carte pour placer le marqueur. Vous pouvez aussi le glisser pour ajuster la position.</span>
            </p>

            {{-- Manual coordinates --}}
            <div class="bg-gray-50 rounded-xl p-4 mb-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Coordonnées GPS (remplies automatiquement ou manuellement)</p>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Latitude</label>
                        <input type="text" name="latitude" id="lat" placeholder="Ex: 6.3622"
                               class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                               value="{{ old('latitude') }}">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Longitude</label>
                        <input type="text" name="longitude" id="lng" placeholder="Ex: 2.0852"
                               class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                               value="{{ old('longitude') }}">
                    </div>
                </div>
                <button type="button" onclick="applyManualCoords()"
                        class="mt-2 text-xs text-blue-700 underline hover:text-green-900 transition">
                    → Appliquer les coordonnées saisies manuellement
                </button>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Adresse ou repère (optionnel)</label>
                <input type="text" name="address" placeholder="Ex: Rue de la Paix, près du marché central de Ouidah"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900"
                       value="{{ old('address') }}">
            </div>

            <div class="flex justify-between mt-6">
                <button type="button" onclick="prevStep(1)" class="px-5 py-2.5 border border-gray-200 text-gray-600 font-medium rounded-xl hover:bg-gray-50 transition">
                    ← Précédent
                </button>
                <button type="button" onclick="nextStep(1)" class="px-6 py-2.5 bg-blue-700 text-green font-semibold rounded-xl hover:bg-blue-800 transition">
                    Suivant →
                </button>
            </div>
        </div>

        {{-- ─── STEP 3: Photos ──────────────────────────────────────────── --}}
        <div id="step-2" class="hidden bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-2">Photos du problème</h2>
            <p class="text-sm text-gray-500 mb-5">Ajoutez jusqu'à 5 photos (max 5 Mo chacune). Les formats acceptés : JPEG, PNG, WEBP.</p>

            <label class="block cursor-pointer">
                <div class="flex flex-col items-center justify-center px-6 py-12 border-2 border-dashed border-gray-300 rounded-xl hover:border-green-400 hover:bg-blue-50 transition">
                    <svg class="w-10 h-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p class="text-sm font-medium text-gray-600">Cliquez pour ajouter des photos</p>
                    <p class="text-xs text-gray-400 mt-1">ou glissez-déposez</p>
                </div>
                <input type="file" name="photos[]" id="photoInput" multiple accept="image/jpeg,image/png,image/webp" class="sr-only">
            </label>
            <div class="photo-preview" id="photoPreview"></div>

            <div class="flex justify-between mt-6">
                <button type="button" onclick="prevStep(2)" class="px-5 py-2.5 border border-gray-200 text-gray-600 font-medium rounded-xl hover:bg-gray-50 transition">
                    ← Précédent
                </button>
                <button type="button" onclick="nextStep(2)" class="px-6 py-2.5 bg-blue-700 text-green font-semibold rounded-xl hover:bg-blue-800 transition">
                    Suivant →
                </button>
            </div>
        </div>

        {{-- ─── STEP 4: Description ─────────────────────────────────────── --}}
        <div id="step-3" class="hidden bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-5">Description du problème</h2>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">Titre du signalement <span class="text-red-500">*</span></label>
                <input type="text" name="title" required maxlength="255"
                       placeholder="Ex: Grand nid-de-poule sur la route de Fidjrossè"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900"
                       value="{{ old('title') }}">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description détaillée <span class="text-red-500">*</span></label>
                <textarea name="description" required rows="5" maxlength="2000"
                          placeholder="Décrivez le problème en détail : sa taille approximative, depuis combien de temps il existe, quel impact il a sur la circulation..."
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900 resize-none">{{ old('description') }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Maximum 2000 caractères.</p>
            </div>

            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6">
                <p class="text-sm text-blue-700 flex items-start gap-2">
                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span><strong>Rappel :</strong> En soumettant ce signalement, vous acceptez que les informations fournies soient traitées par la mairie de Ouidah dans le but d'améliorer les services urbains et la qualité de vie dans la commune.</span>
                </p>
            </div>

            <div class="flex justify-between">
                <button type="button" onclick="prevStep(3)" class="px-5 py-2.5 border border-gray-200 text-gray-600 font-medium rounded-xl hover:bg-gray-50 transition">
                    ← Précédent
                </button>
                <button type="submit" class="px-8 py-2.5 bg-blue-700 text-green font-bold rounded-xl hover:bg-blue-800 transition shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Soumettre le signalement
                </button>
            </div>
        </div>

    </form>
</div>
@endsection

@push('scripts')
{{-- Leaflet est inclus via le bundle Vite (resources/js/app.js) --}}
<script>
// ─── Step navigation ─────────────────────────────────────
let currentStep = 0;
const totalSteps = 4;

function showStep(step) {
    for (let i = 0; i < totalSteps; i++) {
        document.getElementById('step-' + i).classList.add('hidden');
        const badge = document.getElementById('step-badge-' + i);
        const label = document.getElementById('step-label-' + i);
        if (i < step) {
            badge.className = badge.className.replace('bg-gray-200 text-gray-400', '').replace('bg-blue-700 text-green', '') + ' bg-green-100 text-blue-700';
            badge.innerHTML = '✓';
        } else if (i === step) {
            badge.className = badge.className.replace('bg-gray-200 text-gray-400', '').replace('bg-green-100 text-blue-700', '') + ' bg-blue-700 text-green';
            badge.innerHTML = i + 1;
            label.className = label.className.replace('text-gray-400', 'text-blue-700 font-semibold');
        } else {
            badge.className = badge.className.replace('bg-blue-700 text-green', '').replace('bg-green-100 text-blue-700', '') + ' bg-gray-200 text-gray-400';
            badge.innerHTML = i + 1;
            label.className = label.className.replace('text-blue-700 font-semibold', 'text-gray-400');
        }
    }
    document.getElementById('step-' + step).classList.remove('hidden');
    if (step === 1) initMap();
    currentStep = step;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function nextStep(from) {
    if (from === 0) {
        const domainId = document.getElementById('domain_id').value;
        const categoryId = document.getElementById('category_id').value;
        const arr = document.querySelector('select[name="arrondissement_id"]');
        if (!domainId) { alert('Veuillez choisir un domaine (service concerné).'); return; }
        if (!categoryId) { alert('Veuillez sélectionner un type de problème.'); return; }
        if (!arr.value) { alert('Veuillez sélectionner un arrondissement.'); return; }
    }
    if (from + 1 < totalSteps) showStep(from + 1);
}

function prevStep(from) {
    if (from > 0) showStep(from - 1);
}

// ─── Domaine & Catégorie ──────────────────────────────────
let selectedDomainId = '{{ old('domain_id') }}';
let selectedCategoryId = '{{ old('category_id') }}';

function selectDomain(domainId, domainName, domainColor) {
    selectedDomainId = domainId;
    document.getElementById('domain_id').value = domainId;
    document.getElementById('category_id').value = '';
    selectedCategoryId = '';

    // Highlight selected card
    document.querySelectorAll('.domain-card').forEach(card => {
        card.classList.remove('border-blue-500', 'bg-green-50');
        card.classList.add('border-gray-200');
    });
    const selected = document.getElementById('domain-card-' + domainId);
    selected.classList.add('border-blue-500', 'bg-green-50');
    selected.classList.remove('border-gray-200');

    // Show categories section
    document.getElementById('category-section').classList.remove('hidden');
    document.getElementById('category-subtitle').textContent = 'Catégories du domaine : ' + domainName;
    document.getElementById('category-loading').classList.remove('hidden');
    document.getElementById('category-grid').innerHTML = '';

    // Fetch categories for this domain
    fetch('/api/domaines/' + domainId + '/categories', {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(categories => {
        document.getElementById('category-loading').classList.add('hidden');
        const grid = document.getElementById('category-grid');
        if (categories.length === 0) {
            grid.innerHTML = '<p class="col-span-3 text-sm text-gray-400 py-4">Aucune catégorie disponible pour ce domaine.</p>';
            return;
        }
        categories.forEach(cat => {
            const isSelected = String(cat.id) === String(selectedCategoryId);
            grid.innerHTML += `
            <label class="cursor-pointer">
                <input type="radio" name="_cat" value="${cat.id}" class="sr-only peer" ${isSelected ? 'checked' : ''}
                       onchange="document.getElementById('category_id').value=this.value">
                <div class="p-3 border-2 ${isSelected ? 'border-blue-500 bg-green-50' : 'border-gray-200'} rounded-xl text-center peer-checked:border-blue-500 peer-checked:bg-green-50 hover:border-gray-300 transition">
                    <div class="w-8 h-8 rounded-full mx-auto mb-2 flex items-center justify-center" style="background-color:${cat.color}20">
                        <div class="w-3 h-3 rounded-full" style="background-color:${cat.color}"></div>
                    </div>
                    <p class="text-xs font-medium text-gray-700 leading-tight">${cat.name}</p>
                </div>
            </label>`;
        });
    })
    .catch(() => {
        document.getElementById('category-loading').classList.add('hidden');
        document.getElementById('category-grid').innerHTML = '<p class="col-span-3 text-sm text-red-500 py-4">Erreur lors du chargement des catégories. Rechargez la page.</p>';
    });
}

// Restore old values on page load (retour après erreur de validation)
document.addEventListener('DOMContentLoaded', function() {
    if (selectedDomainId) {
        const card = document.getElementById('domain-card-' + selectedDomainId);
        if (card) card.click();
    }
});

// ─── Leaflet Map ─────────────────────────────────────────
let map, marker;
const OUIDAH = [6.3622, 2.0852];

function initMap() {
    if (map) {
        // La carte existe déjà, on force le recalcul de taille
        setTimeout(() => map.invalidateSize(), 100);
        return;
    }
    map = L.map('map').setView(OUIDAH, 14);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 19
    }).addTo(map);

    map.on('click', function(e) {
        setMarker(e.latlng.lat, e.latlng.lng);
        hideGeoError();
    });

    // Recalcule la taille après rendu (évite le bug de carte grise)
    setTimeout(() => map.invalidateSize(), 200);

    // Restaurer d'éventuelles valeurs (retour sur erreur)
    const lat = document.getElementById('lat').value;
    const lng = document.getElementById('lng').value;
    if (lat && lng) setMarker(parseFloat(lat), parseFloat(lng));
}

function setMarker(lat, lng) {
    if (marker) map.removeLayer(marker);
    marker = L.marker([lat, lng], { draggable: true }).addTo(map);
    marker.on('dragend', function(e) {
        const pos = e.target.getLatLng();
        document.getElementById('lat').value = pos.lat.toFixed(7);
        document.getElementById('lng').value = pos.lng.toFixed(7);
    });
    document.getElementById('lat').value = lat.toFixed(7);
    document.getElementById('lng').value = lng.toFixed(7);
    map.setView([lat, lng], 16);
}

function applyManualCoords() {
    const lat = parseFloat(document.getElementById('lat').value);
    const lng = parseFloat(document.getElementById('lng').value);
    if (isNaN(lat) || isNaN(lng)) {
        showGeoError("Veuillez entrer des coordonnées valides. Ex : Latitude 6.3622, Longitude 2.0852");
        return;
    }
    if (lat < -90 || lat > 90 || lng < -180 || lng > 180) {
        showGeoError("Les coordonnées sont hors limites. Vérifiez les valeurs.");
        return;
    }
    setMarker(lat, lng);
    hideGeoError();
}

function showGeoError(msg) {
    const el = document.getElementById('geoError');
    el.innerHTML = '<span style="display:flex;align-items:flex-start;gap:6px"><svg style="width:16px;height:16px;flex-shrink:0;margin-top:1px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span>' + msg + '</span></span>';
    el.classList.remove('hidden');
}
function hideGeoError() {
    document.getElementById('geoError').classList.add('hidden');
}

// ─── GPS ─────────────────────────────────────────────────
document.getElementById('geoBtn').addEventListener('click', function() {
    if (!navigator.geolocation) {
        showGeoError("La géolocalisation n'est pas supportée par votre navigateur. Cliquez sur la carte ou saisissez les coordonnées manuellement.");
        return;
    }

    const btn = document.getElementById('geoBtnText');
    btn.innerHTML = '<svg class="w-4 h-4 animate-spin flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Localisation en cours...';
    document.getElementById('geoNotice').classList.remove('hidden');
    hideGeoError();

    navigator.geolocation.getCurrentPosition(
        // Succès
        function(pos) {
            document.getElementById('geoNotice').classList.add('hidden');
            setMarker(pos.coords.latitude, pos.coords.longitude);
            btn.innerHTML = '<svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Position GPS détectée avec succès !';
            document.getElementById('geoBtn').classList.add('border-blue-500', 'bg-green-50');
        },
        // Erreur
        function(err) {
            document.getElementById('geoNotice').classList.add('hidden');
            btn.innerHTML = '<svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Détecter ma position GPS automatiquement';
            let msg = '';
            switch(err.code) {
                case err.PERMISSION_DENIED:
                    msg = "Accès à la position refusé. Allez dans les paramètres de votre navigateur → Autorisations → Localisation et autorisez ce site. Vous pouvez aussi cliquer directement sur la carte.";
                    break;
                case err.POSITION_UNAVAILABLE:
                    msg = "Position indisponible. Assurez-vous que le GPS de votre appareil est activé, ou cliquez sur la carte pour placer le marqueur manuellement.";
                    break;
                case err.TIMEOUT:
                    msg = "La détection GPS a pris trop de temps. Cliquez directement sur la carte ou saisissez les coordonnées manuellement.";
                    break;
                default:
                    msg = "Erreur GPS inconnue. Cliquez sur la carte pour positionner le marqueur.";
            }
            showGeoError(msg);
        },
        // Options
        {
            enableHighAccuracy: false, // false = réseau WiFi/IP (fonctionne sur PC de bureau)
            timeout: 15000,            // 15 secondes max
            maximumAge: 300000         // accepte une position en cache de 5 min
        }
    );
});

// ─── Photo preview ────────────────────────────────────────
document.getElementById('photoInput').addEventListener('change', function() {
    const preview = document.getElementById('photoPreview');
    preview.innerHTML = '';
    const files = Array.from(this.files).slice(0, 5);
    files.forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
});

// Start at step 0
showStep(0);
</script>
@endpush
