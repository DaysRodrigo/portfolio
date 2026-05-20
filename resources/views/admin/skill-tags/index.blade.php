@extends('layouts.admin')

@section('title', 'Skills')

@section('content')

<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold">Skills</h1>
    <a href="{{ route('admin.skill-tags.create') }}"
       class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
        + New Skill
    </a>
</div>

@if($skillTags->isEmpty())
<div class="rounded-xl border border-gray-200 bg-white p-8 text-center text-sm text-gray-500 shadow-sm">
    No skills yet. <a href="{{ route('admin.skill-tags.create') }}" class="text-indigo-600 hover:underline">Create one.</a>
</div>
@else
<div class="space-y-6">
    @foreach($skillTags as $category => $tags)
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-100 px-5 py-3">
            <h2 class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                {{ $tags->first()->category->label() }}
            </h2>
        </div>
        <ul class="divide-y divide-gray-100">
            @foreach($tags as $tag)
            <li class="flex items-center justify-between px-5 py-3">
                <span class="text-sm font-medium text-gray-800">{{ $tag->name }}</span>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.skill-tags.edit', $tag) }}"
                       class="text-sm text-indigo-600 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('admin.skill-tags.destroy', $tag) }}"
                          onsubmit="return confirm('Delete skill \"{{ addslashes($tag->name) }}\"?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-red-500 hover:underline">Delete</button>
                    </form>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    @endforeach
</div>
@endif

@endsection
