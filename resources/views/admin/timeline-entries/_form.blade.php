@php $editing = isset($timelineEntry); @endphp

<div class="grid gap-6 lg:grid-cols-3">

    {{-- Main fields --}}
    <div class="space-y-5 lg:col-span-2">

        {{-- Title (translatable) --}}
        <div>
            <label class="mb-1 block text-sm font-medium">Title <span class="text-red-500">*</span></label>
            <div class="divide-y divide-gray-200 overflow-hidden rounded-lg border border-gray-300 focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">
                @foreach(config('portfolio.locales') as $locale => $label)
                <div class="flex items-center">
                    <span class="flex w-10 shrink-0 select-none items-center justify-center self-stretch border-r border-gray-200 text-xs font-bold {{ $loop->first ? 'text-indigo-600' : 'text-gray-400' }}">{{ $label }}</span>
                    <input type="text" name="title[{{ $locale }}]"
                           value="{{ old('title.' . $locale, $editing ? ($timelineEntry->getTranslation('title', $locale, false) ?? '') : '') }}"
                           class="flex-1 px-3 py-2 text-sm focus:outline-none"
                           {{ $loop->first ? 'required autofocus' : '' }} maxlength="120"
                           placeholder="{{ $loop->first ? 'e.g. Senior Software Engineer, BSc Computer Science' : '' }}">
                </div>
                @endforeach
            </div>
            @error('title.en') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">Organization <span class="text-red-500">*</span></label>
            <input type="text" name="organization" value="{{ old('organization', $timelineEntry->organization ?? '') }}"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                   required maxlength="120"
                   placeholder="e.g. Acme Corp, University of Lisbon">
            @error('organization') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">Location <span class="text-red-500">*</span></label>
            <input type="text" name="location" value="{{ old('location', $timelineEntry->location ?? '') }}"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                   required maxlength="120"
                   placeholder="e.g. Lisbon, Portugal · Remote">
            @error('location') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium">Start <span class="text-red-500">*</span></label>
                <input type="month" name="start_date"
                       value="{{ old('start_date', $editing ? $timelineEntry->start_date->format('Y-m') : '') }}"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                       required>
                @error('start_date') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium">End <span class="text-gray-400 font-normal">(leave blank = Present)</span></label>
                <input type="month" name="end_date"
                       value="{{ old('end_date', $editing && $timelineEntry->end_date ? $timelineEntry->end_date->format('Y-m') : '') }}"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                @error('end_date') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Description (translatable textarea) --}}
        <div>
            <label class="mb-1 block text-sm font-medium">Description <span class="text-red-500">*</span></label>
            <div class="divide-y divide-gray-200 overflow-hidden rounded-lg border border-gray-300 focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">
                @foreach(config('portfolio.locales') as $locale => $label)
                <div class="flex items-start">
                    <span class="flex w-10 shrink-0 select-none items-center justify-center self-stretch border-r border-gray-200 pt-2 text-xs font-bold {{ $loop->first ? 'text-indigo-600' : 'text-gray-400' }}">{{ $label }}</span>
                    <textarea name="description[{{ $locale }}]" rows="5" maxlength="5000"
                              class="flex-1 px-3 py-2 text-sm focus:outline-none"
                              {{ $loop->first ? 'required' : '' }}>{{ old('description.' . $locale, $editing ? ($timelineEntry->getTranslation('description', $locale, false) ?? '') : '') }}</textarea>
                </div>
                @endforeach
            </div>
            <p class="mt-1 text-xs text-gray-400">Max 5000 characters per language.</p>
            @error('description.en') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">Skills</label>
            <textarea name="skills" rows="4"
                      class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm font-mono focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                      placeholder="PHP&#10;Laravel&#10;Docker">{{ old('skills', $editing ? implode("\n", $timelineEntry->skills ?? []) : '') }}</textarea>
            <p class="mt-1 text-xs text-gray-400">One skill per line (or comma-separated).</p>
            @error('skills') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

    </div>

    {{-- Sidebar --}}
    <div class="space-y-5">

        <div>
            <label class="mb-1 block text-sm font-medium">Type <span class="text-red-500">*</span></label>
            <select name="type"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                    required>
                @foreach($types as $type)
                <option value="{{ $type->value }}"
                    {{ old('type', $timelineEntry->type->value ?? '') === $type->value ? 'selected' : '' }}>
                    {{ $type->label() }}
                </option>
                @endforeach
            </select>
            @error('type') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">Display Order</label>
            <input type="number" name="display_order" min="0"
                   value="{{ old('display_order', $timelineEntry->display_order ?? 0) }}"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
            <p class="mt-1 text-xs text-gray-400">Lower = appears first. Tie-breaks by start date (newest first).</p>
        </div>

    </div>
</div>
