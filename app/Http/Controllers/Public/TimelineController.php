<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Data\TimelineData;
use App\Http\Controllers\Controller;

class TimelineController extends Controller
{
    public function index()
    {
        $entries = TimelineData::all();

        return view('public.timeline', compact('entries'));
    }
}
