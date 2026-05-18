<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::published()->ordered()->with('skillTags')->get();

        return view('public.projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        abort_unless($project->status->isPublic(), 404);

        $project->load('skillTags');

        return view('public.projects.show', compact('project'));
    }
}
