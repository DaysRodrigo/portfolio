@extends('layouts.admin')

@section('title', 'Projects')

@section('content')

<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold">Projects</h1>
    <a href="{{ route('admin.projects.create') }}"
       class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
        + New Project
    </a>
</div>

<div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
    <table class="w-full text-sm">
        <thead class="border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
            <tr>
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">Title</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Stars</th>
                <th class="px-4 py-3">Last Sync</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($projects as $project)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-400">{{ $project->display_order }}</td>
                <td class="px-4 py-3">
                    <div class="font-medium">{{ $project->title }}</div>
                    <div class="text-xs text-gray-400">{{ $project->slug }}</div>
                </td>
                <td class="px-4 py-3">
                    <span class="rounded-full px-2.5 py-0.5 text-xs font-medium
                        {{ $project->status->value === 'published' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $project->status->value === 'draft'     ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $project->status->value === 'archived'  ? 'bg-gray-100 text-gray-600' : '' }}">
                        {{ $project->status->label() }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    {{ $project->github_stars ?? '—' }}
                </td>
                <td class="px-4 py-3 text-gray-400">
                    {{ $project->github_synced_at?->diffForHumans() ?? 'Never' }}
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center justify-end gap-3">
                        @if($project->repo_url)
                        <form method="POST" action="{{ route('admin.projects.sync-github', $project) }}">
                            @csrf
                            <button type="submit"
                                    class="text-xs text-indigo-600 hover:underline"
                                    title="Sync GitHub stats">
                                ↻ Sync
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('admin.projects.edit', $project) }}"
                           class="text-xs text-gray-600 hover:text-gray-900">Edit</a>
                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}"
                              onsubmit="return confirm('Delete ' + @json($project->title) + '?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:text-red-700">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-8 text-center text-gray-400">No projects yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
