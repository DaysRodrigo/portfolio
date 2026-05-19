@extends('layouts.admin')

@section('title', 'Edit: ' . $project->title)

@section('content')

<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('admin.projects.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Projects</a>
    <h1 class="text-2xl font-bold">Edit: {{ $project->title }}</h1>
</div>

<form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data" class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
    @csrf
    @method('PUT')

    @include('admin.projects._form')

    <div class="mt-8 flex gap-3 border-t border-gray-100 pt-6">
        <button type="submit"
                class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
            Save Changes
        </button>
        <a href="{{ route('admin.projects.index') }}"
           class="rounded-lg border border-gray-300 px-5 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
            Cancel
        </a>
        @if($project->repo_url)
        <form method="POST" action="{{ route('admin.projects.sync-github', $project) }}" class="ml-auto">
            @csrf
            <button type="submit"
                    class="rounded-lg border border-indigo-300 px-5 py-2 text-sm font-medium text-indigo-600 hover:bg-indigo-50">
                ↻ Sync GitHub
            </button>
        </form>
        @endif
    </div>
</form>

@endsection
