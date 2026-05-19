@extends('layouts.admin')

@section('title', 'Profile')

@section('content')
    <div class="max-w-2xl space-y-6">

        <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
            @include('profile.partials.update-password-form')
        </div>

        <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
            @include('profile.partials.delete-user-form')
        </div>

    </div>
@endsection
