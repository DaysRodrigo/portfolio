<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\TimelineEntry;

class TimelineController extends Controller
{
    public function index()
    {
        $entries = TimelineEntry::orderBy('display_order')->orderByDesc('start_date')->get();

        return view('public.timeline', compact('entries'));
    }
}
