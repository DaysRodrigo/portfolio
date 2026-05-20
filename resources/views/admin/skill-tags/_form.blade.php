@php $editing = isset($skillTag); @endphp

<div class="max-w-sm space-y-5">

    <div>
        <label class="mb-1 block text-sm font-medium">Name <span class="text-red-500">*</span></label>
        <input type="text" name="name" value="{{ old('name', $skillTag->name ?? '') }}"
               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
               required maxlength="60" autofocus>
        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium">Category <span class="text-red-500">*</span></label>
        <select name="category"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                required>
            <option value="">— select —</option>
            @foreach($categories as $category)
            <option value="{{ $category->value }}"
                {{ old('category', $skillTag->category->value ?? '') === $category->value ? 'selected' : '' }}>
                {{ $category->label() }}
            </option>
            @endforeach
        </select>
        @error('category') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
    </div>

</div>
