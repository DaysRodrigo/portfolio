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

        {{-- Images --}}
        <div>
            <label class="mb-2 block text-sm font-medium">Screenshots</label>

            @if($editing && $project->images->count())
            <p class="mb-1 text-xs text-gray-400">Drag to reorder · ✕ marks for removal (applied on Save)</p>
            <div class="mb-3 grid grid-cols-3 gap-2 sm:grid-cols-4" id="images-grid">
                @foreach($project->images->sortBy('order') as $image)
                <div class="group relative cursor-grab active:cursor-grabbing"
                     id="img-{{ $image->id }}"
                     draggable="true"
                     data-id="{{ $image->id }}">
                    <img src="{{ Storage::url($image->path) }}" alt="{{ $image->alt ?? '' }}"
                         class="h-24 w-full rounded-lg object-cover pointer-events-none select-none">
                    <input type="hidden" name="image_order[]" value="{{ $image->id }}">
                    <button type="button"
                            onclick="markDelete({{ $image->id }})"
                            class="absolute right-1 top-1 rounded bg-red-600 px-1.5 py-0.5 text-xs text-white opacity-0 transition group-hover:opacity-100">
                        ✕
                    </button>
                </div>
                @endforeach
            </div>
            @endif

            <input type="file" name="images[]" id="images-input" multiple accept="image/*"
                   class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
            <p class="mt-1 text-xs text-gray-400">PNG, JPG, WebP — max 1.5 MB each. Multiple files allowed.</p>
            @error('images.*') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
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

@push('overlay')
{{-- Upload error modal (inline styles — independent of Tailwind build) --}}
<div id="upload-error-modal" style="display:none;position:fixed;inset:0;z-index:9999;align-items:center;justify-content:center;background:rgba(0,0,0,.5);padding:1rem;" role="dialog" aria-modal="true">
    <div style="width:100%;max-width:24rem;background:#fff;border-radius:1rem;padding:1.5rem;box-shadow:0 20px 60px rgba(0,0,0,.25);">
        <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1rem;">
            <span style="display:flex;align-items:center;justify-content:center;width:2.5rem;height:2.5rem;border-radius:9999px;background:#fee2e2;color:#dc2626;flex-shrink:0;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10A8 8 0 1 1 2 10a8 8 0 0 1 16 0zm-7 4a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1-9a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V6a1 1 0 0 0-1-1z" clip-rule="evenodd"/>
                </svg>
            </span>
            <h3 style="font-size:1rem;font-weight:600;color:#111;">Upload error</h3>
        </div>
        <p id="upload-error-msg" style="font-size:.875rem;color:#4b5563;margin-bottom:1.25rem;white-space:pre-line;"></p>
        <button id="upload-error-close" style="width:100%;background:#4f46e5;color:#fff;font-weight:600;font-size:.875rem;padding:.5rem 1rem;border:none;border-radius:.5rem;cursor:pointer;">
            OK
        </button>
    </div>
</div>

<script>
// Mark image for deletion on Save (no immediate server call)
function markDelete(imageId) {
    var el = document.getElementById('img-' + imageId);
    if (!el) return;
    // Toggle: if already marked, unmark
    if (el.dataset.markedDelete === '1') {
        el.dataset.markedDelete = '0';
        el.style.opacity = '1';
        el.style.outline = '';
        var hidden = document.getElementById('del-' + imageId);
        if (hidden) hidden.remove();
        return;
    }
    el.dataset.markedDelete = '1';
    el.style.opacity = '.35';
    el.style.outline = '2px solid #dc2626';
    // Add hidden input so the form sends this ID for deletion
    var hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = 'delete_images[]';
    hidden.id = 'del-' + imageId;
    hidden.value = imageId;
    el.appendChild(hidden);
}

// Drag-and-drop reorder
(function () {
    var grid = document.getElementById('images-grid');
    if (!grid) return;

    var dragging = null;

    grid.addEventListener('dragstart', function (e) {
        dragging = e.target.closest('[draggable]');
        if (dragging) {
            dragging.style.opacity = '0.4';
            e.dataTransfer.effectAllowed = 'move';
        }
    });

    grid.addEventListener('dragend', function () {
        if (dragging) dragging.style.opacity = dragging.dataset.markedDelete === '1' ? '.35' : '1';
        dragging = null;
        syncOrder();
    });

    grid.addEventListener('dragover', function (e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        var target = e.target.closest('[draggable]');
        if (target && target !== dragging) {
            var rect = target.getBoundingClientRect();
            var after = e.clientX > rect.left + rect.width / 2;
            grid.insertBefore(dragging, after ? target.nextSibling : target);
        }
    });

    function syncOrder() {
        // Update all image_order hidden inputs to match DOM order
        var items = grid.querySelectorAll('[data-id]');
        items.forEach(function (item) {
            var input = item.querySelector('input[name="image_order[]"]');
            if (input) input.value = item.dataset.id;
        });
    }
})();

(function () {
    var MAX_FILE  = 1.5 * 1024 * 1024;
    var MAX_TOTAL = 10  * 1024 * 1024;

    var modal    = document.getElementById('upload-error-modal');
    var msgEl    = document.getElementById('upload-error-msg');
    var closeBtn = document.getElementById('upload-error-close');

    function showError(msg) {
        msgEl.textContent = msg;
        modal.style.display = 'flex';
    }

    function hideModal() {
        modal.style.display = 'none';
    }

    closeBtn.addEventListener('click', hideModal);
    modal.addEventListener('click', function (e) {
        if (e.target === modal) hideModal();
    });

    var input = document.getElementById('images-input');
    if (!input) return;

    input.closest('form').addEventListener('submit', function (e) {
        var files = Array.from(input.files);
        if (!files.length) return;

        var oversized = files.filter(function (f) { return f.size > MAX_FILE; });
        if (oversized.length) {
            e.preventDefault();
            var names = oversized.map(function (f) {
                return '• ' + f.name + ' (' + (f.size / 1024 / 1024).toFixed(2) + ' MB)';
            }).join('\n');
            showError('The following file(s) exceed the 1.5 MB limit:\n\n' + names);
            return;
        }

        var total = files.reduce(function (sum, f) { return sum + f.size; }, 0);
        if (total > MAX_TOTAL) {
            e.preventDefault();
            showError('Total upload size (' + (total / 1024 / 1024).toFixed(2) + ' MB) exceeds the 10 MB limit. Please select fewer files.');
        }
    });
})();
</script>
@endpush
