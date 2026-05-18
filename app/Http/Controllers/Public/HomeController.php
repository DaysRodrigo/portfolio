<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\SkillTag;

class HomeController extends Controller
{
    public function index()
    {
        $projects = Project::published()->ordered()->with('skillTags')->take(3)->get();
        $skills   = SkillTag::all()->groupBy('category');

        return view('public.home', compact('projects', 'skills'));
    }
}
