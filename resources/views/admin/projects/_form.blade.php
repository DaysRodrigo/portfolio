@php $editing = isset($project); @endphp

<div class="grid gap-6 lg:grid-cols-3">

    {{-- Main fields --}}
    <div class="space-y-5 lg:col-span-2">

        <div>
            <label class="mb-1 block text-sm font-medium">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $project->title ?? '') }}"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                   required maxlength="120">
            @error('title') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">Slug <span class="text-red-500">*</span></label>
            <input type="text" name="slug" value="{{ old('slug', $project->slug ?? '') }}"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm font-mono focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                   required maxlength="120">
            @error('slug') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">Short Description <span class="text-red-500">*</span></label>
            <textarea name="description" rows="3"
                      class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                      required>{{ old('description', $project->description ?? '') }}</textarea>
            @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">Long Description</label>
            <textarea name="long_description" rows="6"
                      class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                      >{{ old('long_description', $project->long_description ?? '') }}</textarea>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium">Repo URL</label>
                <input type="url" name="repo_url" value="{{ old('repo_url', $project->repo_url ?? '') }}"
                       placeholder="https://github.com/..."
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                @error('repo_url') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium">Live URL</label>
                <input type="url" name="live_url" value="{{ old('live_url', $project->live_url ?? '') }}"
                       placeholder="https://..."
                       class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                @error('live_url') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

    </div>

    {{-- Sidebar fields --}}
    <div class="space-y-5">

        <div>
            <label class="mb-1 block text-sm font-medium">Status <span class="text-red-500">*</span></label>
            <select name="status"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                @foreach($statuses as $status)
                <option value="{{ $status->value }}"
                    {{ old('status', $project->status->value ?? 'draft') === $status->value ? 'selected' : '' }}>
                    {{ $status->label() }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">Display Order</label>
            <input type="number" name="display_order" min="0"
                   value="{{ old('display_order', $project->display_order ?? 0) }}"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium">Skills</label>
            <div class="max-h-64 space-y-3 overflow-y-auto rounded-lg border border-gray-200 p-3">
                @foreach($skillTags as $category => $tags)
                <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">{{ $category }}</p>
                    @foreach($tags as $tag)
                    <label class="flex items-center gap-2 py-0.5 text-sm">
                        <input type="checkbox" name="skill_tags[]" value="{{ $tag->id }}"
                               {{ in_array($tag->id, $selectedSkills ?? []) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600">
                        {{ $tag->name }}
                    </label>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
