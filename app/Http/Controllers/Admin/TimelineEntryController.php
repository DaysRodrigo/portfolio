<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\TimelineType;
use App\Http\Controllers\Controller;
use App\Models\TimelineEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TimelineEntryController extends Controller
{
    public function index(): View
    {
        $entries = TimelineEntry::orderBy('display_order')->orderByDesc('start_date')->get();

        return view('admin.timeline-entries.index', compact('entries'));
    }

    public function create(): View
    {
        $types = TimelineType::cases();

        return view('admin.timeline-entries.create', compact('types'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'type'          => ['required', Rule::enum(TimelineType::class)],
            'title'         => 'required|string|max:120',
            'organization'  => 'required|string|max:120',
            'location'      => 'required|string|max:120',
            'start_date'    => 'required|date_format:Y-m',
            'end_date'      => 'nullable|date_format:Y-m|after_or_equal:start_date',
            'description'   => 'required|string|max:5000',
            'skills'        => 'nullable|string|max:2000',
            'display_order' => 'nullable|integer|min:0|max:65535',
        ]);

        $entry = TimelineEntry::create($this->prepareData($data));

        Log::info('TimelineEntry created', ['user_id' => auth()->id(), 'entry_id' => $entry->id, 'title' => $entry->title]);

        return redirect()->route('admin.timeline-entries.index')
            ->with('success', "\"{$entry->title}\" added to timeline.");
    }

    public function edit(TimelineEntry $timelineEntry): View
    {
        $types = TimelineType::cases();

        return view('admin.timeline-entries.edit', compact('timelineEntry', 'types'));
    }

    public function update(Request $request, TimelineEntry $timelineEntry): RedirectResponse
    {
        $data = $request->validate([
            'type'          => ['required', Rule::enum(TimelineType::class)],
            'title'         => 'required|string|max:120',
            'organization'  => 'required|string|max:120',
            'location'      => 'required|string|max:120',
            'start_date'    => 'required|date_format:Y-m',
            'end_date'      => 'nullable|date_format:Y-m|after_or_equal:start_date',
            'description'   => 'required|string|max:5000',
            'skills'        => 'nullable|string|max:2000',
            'display_order' => 'nullable|integer|min:0|max:65535',
        ]);

        $timelineEntry->update($this->prepareData($data));

        Log::info('TimelineEntry updated', ['user_id' => auth()->id(), 'entry_id' => $timelineEntry->id, 'title' => $timelineEntry->title]);

        return redirect()->route('admin.timeline-entries.index')
            ->with('success', "\"{$timelineEntry->title}\" updated.");
    }

    public function destroy(TimelineEntry $timelineEntry): RedirectResponse
    {
        $title = $timelineEntry->title;
        $id    = $timelineEntry->id;
        $timelineEntry->delete();

        Log::warning('TimelineEntry deleted', ['user_id' => auth()->id(), 'entry_id' => $id, 'title' => $title]);

        return redirect()->route('admin.timeline-entries.index')
            ->with('success', "\"{$title}\" removed from timeline.");
    }

    /** @param array<string, mixed> $data */
    private function prepareData(array $data): array
    {
        // Convert 'Y-m' month strings to full dates (first of month)
        $data['start_date'] = $data['start_date'] . '-01';
        $data['end_date']   = isset($data['end_date']) && $data['end_date'] !== ''
            ? $data['end_date'] . '-01'
            : null;

        // Parse skills from newline/comma-separated textarea into array
        $raw = trim($data['skills'] ?? '');
        if ($raw === '') {
            $data['skills'] = null;
        } else {
            $items = preg_split('/[\r\n,]+/', $raw);
            $data['skills'] = array_values(array_filter(array_map('trim', $items)));
        }

        return $data;
    }
}
