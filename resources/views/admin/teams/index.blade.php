@extends('layouts.app')
@section('title', 'Équipes techniques')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Équipes techniques</h1>
            <p class="text-sm text-gray-500 mt-1">Gérez les équipes par domaine (Voirie, SBEE, SONEB…)</p>
        </div>
        <a href="{{ route('admin.teams.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-700 text-white font-medium rounded-lg hover:bg-blue-800 transition text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nouvelle équipe
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Équipe</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Domaine</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Contact</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Signalements</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Statut</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($teams as $team)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3">
                        <p class="text-sm font-medium text-gray-900">{{ $team->name }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ Str::limit($team->description, 50) }}</p>
                    </td>
                    <td class="px-5 py-3">
                        @if($team->domain)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium" style="background-color: {{ $team->domain->color }}20; color: {{ $team->domain->color }}">
                                <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $team->domain->color }}"></span>
                                {{ $team->domain->name }}
                            </span>
                        @else
                            <span class="text-xs text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-3">
                        <p class="text-xs text-gray-600">{{ $team->contact_phone ?? '—' }}</p>
                        <p class="text-xs text-gray-400">{{ $team->contact_email ?? '' }}</p>
                    </td>
                    <td class="px-5 py-3">
                        <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">{{ $team->reports_count }}</span>
                    </td>
                    <td class="px-5 py-3">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $team->is_active ? 'bg-green-100 text-blue-700' : 'bg-red-100 text-red-600' }}">
                            {{ $team->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.teams.edit', $team) }}" title="Modifier" class="p-1.5 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            @if($team->reports_count === 0)
                            <form action="{{ route('admin.teams.destroy', $team) }}" method="POST" onsubmit="return confirm('Supprimer cette équipe ?')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Supprimer" class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-10 text-center text-gray-400 text-sm">Aucune équipe créée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
