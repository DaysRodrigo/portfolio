<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function edit(): View
    {
        $profile = Profile::instance();

        return view('admin.about.edit', compact('profile'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:100',
            'job_title'             => ['required', 'array'],
            'job_title.en'          => ['required', 'string', 'max:100'],
            'job_title.pt_BR'       => ['nullable', 'string', 'max:100'],
            'tagline'               => ['required', 'array'],
            'tagline.en'            => ['required', 'string', 'max:255'],
            'tagline.pt_BR'         => ['nullable', 'string', 'max:255'],
            'about'                 => ['nullable', 'array'],
            'about.en'              => ['nullable', 'string', 'max:2000'],
            'about.pt_BR'           => ['nullable', 'string', 'max:2000'],
            'github_url'            => 'nullable|url:http,https|max:255',
            'github_username'       => 'nullable|string|max:100',
            'linkedin_url'          => 'nullable|url:http,https|max:255',
            'linkedin_username'     => 'nullable|string|max:100',
            'email'                 => 'nullable|email:rfc,dns|max:255',
            'whatsapp'              => ['nullable', 'string', 'max:30', 'regex:/^[0-9]+$/'],
            'whatsapp_label'        => 'nullable|string|max:30',
        ]);

        $profile = Profile::instance();
        $profile->update($data);

        Log::info('Profile updated', ['user_id' => auth()->id()]);

        return redirect()->route('admin.about.edit')
            ->with('success', 'Public profile updated.');
    }
}
