@extends('layouts.admin')

@section('title', 'Public Profile')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold">Public Profile</h1>
    <p class="mt-1 text-sm text-gray-500">What visitors see on the site — hero section, contact links, and meta info.</p>
</div>

<form method="POST" action="{{ route('admin.about.update') }}"
      class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
    @csrf
    @method('PATCH')

    @include('admin.about._form')

    <div class="mt-8 flex gap-3 border-t border-gray-100 pt-6">
        <button type="submit"
                class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
            Save Changes
        </button>
    </div>
</form>

@endsection
