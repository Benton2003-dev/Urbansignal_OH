@extends('layouts.app')
@section('title', 'Modifier le domaine')

@section('content')
<div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.domains.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 transition mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Retour aux domaines
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Modifier — {{ $domain->name }}</h1>
        <div class="flex gap-4 mt-2 text-xs text-gray-500">
            <span>{{ $domain->categories_count }} catégorie(s)</span>
            <span>{{ $domain->teams_count }} équipe(s)</span>
            <span>{{ $domain->reports_count }} signalement(s)</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('admin.domains.update', $domain) }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom du domaine <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $domain->name) }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-400 @error('name') border-red-400 @enderror">
                @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-400">{{ old('description', $domain->description) }}</textarea>
            </div>

            <div>
                <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Couleur</label>
                <div class="flex items-center gap-3">
                    <input type="color" id="color" name="color" value="{{ old('color', $domain->color) }}"
                           class="w-10 h-10 rounded-lg border border-gray-300 cursor-pointer p-0.5">
                    <span class="text-sm text-gray-500">Couleur représentative du domaine</span>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $domain->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 text-green-600 rounded border-gray-300 focus:ring-green-500">
                <label for="is_active" class="text-sm font-medium text-gray-700">Domaine actif</label>
            </div>

            <div class="pt-2 flex gap-3">
                <button type="submit" class="px-5 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition">
                    Enregistrer
                </button>
                <a href="{{ route('admin.domains.index') }}" class="px-5 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
