@extends('layouts.admin')

@section('title', 'Timeline')

@section('content')

<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold">Timeline</h1>
    <a href="{{ route('admin.timeline-entries.create') }}"
       class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
        + New Entry
    </a>
</div>

@if($entries->isEmpty())
<div class="rounded-xl border border-gray-200 bg-white p-8 text-center text-sm text-gray-500 shadow-sm">
    No entries yet. <a href="{{ route('admin.timeline-entries.create') }}" class="text-indigo-600 hover:underline">Create one.</a>
</div>
@else
<div class="rounded-xl border border-gray-200 bg-white shadow-sm">
    <ul class="divide-y divide-gray-100">
        @foreach($entries as $entry)
        <li class="flex items-start justify-between gap-4 px-5 py-4">
            <div class="flex items-start gap-3 min-w-0">
                <span class="mt-0.5 inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-white text-xs
                    {{ $entry->type === \App\Enums\TimelineType::Work ? 'bg-indigo-600' : 'bg-emerald-600' }}">
                    {{ $entry->type === \App\Enums\TimelineType::Work ? 'W' : 'E' }}
                </span>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $entry->title }}</p>
                    <p class="text-xs text-gray-500">
                        {{ $entry->organization }} · {{ $entry->location }}
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $entry->start_date->format('M Y') }} —
                        {{ $entry->end_date ? $entry->end_date->format('M Y') : 'Present' }}
                    </p>
                </div>
            </div>
            <div class="flex shrink-0 items-center gap-3">
                <a href="{{ route('admin.timeline-entries.edit', $entry) }}"
                   class="text-sm text-indigo-600 hover:underline">Edit</a>
                <form method="POST" action="{{ route('admin.timeline-entries.destroy', $entry) }}"
                      onsubmit="return confirm('Delete \"{{ addslashes($entry->title) }}\"?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-500 hover:underline">Delete</button>
                </form>
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endif

@endsection
