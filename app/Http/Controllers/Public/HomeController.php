<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\SkillTag;
use App\Models\TimelineEntry;

class HomeController extends Controller
{
    public function index()
    {
        $projects  = Project::published()->ordered()->with('skillTags', 'images')->get();
        $skills    = SkillTag::orderBy('category')->orderBy('name')->get()->groupBy('category');
        $timeline  = TimelineEntry::orderBy('display_order')->orderByDesc('start_date')->get();

        return view('public.home', compact('projects', 'skills', 'timeline'));
    }
}
