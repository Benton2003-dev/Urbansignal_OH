@extends('layouts.app')
@section('title', 'Catégories')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Catégories de signalement</h1>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition text-sm">
            + Nouvelle catégorie
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Catégorie</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Description</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Couleur</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Signalements</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Statut</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($categories as $cat)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full" style="background-color: {{ $cat->color }}"></div>
                            <span class="text-sm font-medium text-gray-900">{{ $cat->name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-sm text-gray-500 max-w-xs">
                        <span class="line-clamp-1">{{ $cat->description ?? '—' }}</span>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-5 h-5 rounded border border-gray-200" style="background-color: {{ $cat->color }}"></div>
                            <span class="text-xs text-gray-500 font-mono">{{ $cat->color }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">{{ $cat->reports_count }}</span>
                    </td>
                    <td class="px-5 py-3">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $cat->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                            {{ $cat->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="text-xs text-green-600 hover:text-green-800 font-medium transition">Modifier</a>
                            @if($cat->reports_count === 0)
                            <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-medium transition">Supprimer</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection
