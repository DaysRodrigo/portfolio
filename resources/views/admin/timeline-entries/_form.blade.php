@php $editing = isset($timelineEntry); @endphp

<div class="grid gap-6 lg:grid-cols-3">

    {{-- Main fields --}}
    <div class="space-y-5 lg:col-span-2">

        <div>
            <label class="mb-1 block text-sm font-medium">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $timelineEntry->title ?? '') }}"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                   required maxlength="120" autofocus
                   placeholder="e.g. Senior Software Engineer, BSc Computer Science">
            @error('title') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
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

        <div>
            <label class="mb-1 block text-sm font-medium">Description <span class="text-red-500">*</span></label>
            <textarea name="description" rows="5" maxlength="5000"
                      class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                      required>{{ old('description', $timelineEntry->description ?? '') }}</textarea>
            <p class="mt-1 text-xs text-gray-400">Max 5000 characters.</p>
            @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
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
