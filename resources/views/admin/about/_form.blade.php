<div class="grid gap-6 lg:grid-cols-3">

    {{-- Main fields --}}
    <div class="space-y-5 lg:col-span-2">

        <div>
            <label class="mb-1 block text-sm font-medium">Full Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $profile->name) }}"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                   required maxlength="100">
            @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Job Title (translatable) --}}
        <div>
            <label class="mb-1 block text-sm font-medium">Job Title <span class="text-red-500">*</span></label>
            <div class="divide-y divide-gray-200 overflow-hidden rounded-lg border border-gray-300 focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">
                @foreach(config('portfolio.locales') as $locale => $label)
                <div class="flex items-center">
                    <span class="flex w-10 shrink-0 select-none items-center justify-center self-stretch border-r border-gray-200 text-xs font-bold {{ $loop->first ? 'text-indigo-600' : 'text-gray-400' }}">{{ $label }}</span>
                    <input type="text" name="job_title[{{ $locale }}]"
                           value="{{ old('job_title.' . $locale, $profile->getTranslation('job_title', $locale, false) ?? '') }}"
                           class="flex-1 px-3 py-2 text-sm focus:outline-none"
                           {{ $loop->first ? 'required' : '' }} maxlength="100"
                           placeholder="{{ $loop->first ? 'e.g. Backend Engineer' : '' }}">
                </div>
                @endforeach
            </div>
            @error('job_title.en') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Tagline (translatable) --}}
        <div>
            <label class="mb-1 block text-sm font-medium">Tagline <span class="text-red-500">*</span></label>
            <div class="divide-y divide-gray-200 overflow-hidden rounded-lg border border-gray-300 focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">
                @foreach(config('portfolio.locales') as $locale => $label)
                <div class="flex items-center">
                    <span class="flex w-10 shrink-0 select-none items-center justify-center self-stretch border-r border-gray-200 text-xs font-bold {{ $loop->first ? 'text-indigo-600' : 'text-gray-400' }}">{{ $label }}</span>
                    <input type="text" name="tagline[{{ $locale }}]"
                           value="{{ old('tagline.' . $locale, $profile->getTranslation('tagline', $locale, false) ?? '') }}"
                           class="flex-1 px-3 py-2 text-sm focus:outline-none"
                           {{ $loop->first ? 'required' : '' }} maxlength="255"
                           placeholder="{{ $loop->first ? 'e.g. Building reliable systems with PHP, Laravel & Docker.' : '' }}">
                </div>
                @endforeach
            </div>
            <p class="mt-1 text-xs text-gray-400">Short punchy line shown in the hero, below the job title.</p>
            @error('tagline.en') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- About (translatable textarea) --}}
        <div>
            <label class="mb-1 block text-sm font-medium">About</label>
            <div class="divide-y divide-gray-200 overflow-hidden rounded-lg border border-gray-300 focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">
                @foreach(config('portfolio.locales') as $locale => $label)
                <div class="flex items-start">
                    <span class="flex w-10 shrink-0 select-none items-center justify-center self-stretch border-r border-gray-200 pt-2 text-xs font-bold {{ $loop->first ? 'text-indigo-600' : 'text-gray-400' }}">{{ $label }}</span>
                    <textarea name="about[{{ $locale }}]" rows="5" maxlength="2000"
                              class="flex-1 px-3 py-2 text-sm focus:outline-none"
                              placeholder="{{ $loop->first ? 'A personal paragraph — who you are, where you come from, what drives you.' : '' }}"
                              >{{ old('about.' . $locale, $profile->getTranslation('about', $locale, false) ?? '') }}</textarea>
                </div>
                @endforeach
            </div>
            <p class="mt-1 text-xs text-gray-400">Shown below the tagline in the hero section. Max 2000 characters.</p>
            @error('about.en') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

    </div>

    {{-- Sidebar: contact links --}}
    <div class="space-y-5">

        <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Contact & Social</p>

        <div>
            <label class="mb-1 block text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $profile->email) }}"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                   maxlength="255">
            @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">GitHub URL</label>
            <input type="url" name="github_url" value="{{ old('github_url', $profile->github_url) }}"
                   placeholder="https://github.com/..."
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                   maxlength="255">
            @error('github_url') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">GitHub Username</label>
            <input type="text" name="github_username" value="{{ old('github_username', $profile->github_username) }}"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm font-mono focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                   maxlength="100" placeholder="DaysRodrigo">
            @error('github_username') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">LinkedIn URL</label>
            <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url) }}"
                   placeholder="https://linkedin.com/in/..."
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                   maxlength="255">
            @error('linkedin_url') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">LinkedIn Username</label>
            <input type="text" name="linkedin_username" value="{{ old('linkedin_username', $profile->linkedin_username) }}"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm font-mono focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                   maxlength="100" placeholder="days-rodrigo">
            @error('linkedin_username') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">WhatsApp <span class="text-gray-400 font-normal text-xs">(digits only)</span></label>
            <input type="text" name="whatsapp" value="{{ old('whatsapp', $profile->whatsapp) }}"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm font-mono focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                   maxlength="30" placeholder="5521991623039">
            <p class="mt-1 text-xs text-gray-400">Used in the wa.me/ link. Digits only, no +.</p>
            @error('whatsapp') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">WhatsApp Display</label>
            <input type="text" name="whatsapp_label" value="{{ old('whatsapp_label', $profile->whatsapp_label) }}"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                   maxlength="30" placeholder="+55 21 99162-3039">
            <p class="mt-1 text-xs text-gray-400">How the number is shown on the site.</p>
            @error('whatsapp_label') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

    </div>
</div>
