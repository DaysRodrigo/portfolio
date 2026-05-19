<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\SkillTag;
use App\Services\GitHubService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function __construct(private readonly GitHubService $github) {}

    public function index(): View
    {
        $projects = Project::with('skillTags')->orderBy('display_order')->get();

        return view('admin.projects.index', compact('projects'));
    }

    public function create(): View
    {
        $skillTags = SkillTag::orderBy('category')->orderBy('name')->get()->groupBy('category');
        $statuses  = ProjectStatus::cases();

        return view('admin.projects.create', compact('skillTags', 'statuses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'            => 'required|string|max:120',
            'slug'             => 'required|string|max:120|unique:projects,slug|alpha_dash',
            'description'      => 'required|string',
            'long_description' => 'nullable|string',
            'repo_url'         => 'nullable|url|max:255',
            'live_url'         => 'nullable|url|max:255',
            'status'           => 'required|in:draft,published,archived',
            'display_order'    => 'integer|min:0',
            'skill_tags'       => 'nullable|array',
            'skill_tags.*'     => 'integer|exists:skill_tags,id',
            'images'           => 'nullable|array',
            'images.*'         => 'image:jpeg,png,webp,gif|max:1536',
        ]);

        $project = Project::create($data);
        $project->skillTags()->sync($data['skill_tags'] ?? []);

        $this->storeImages($request, $project);

        Log::info('Project created', ['user_id' => auth()->id(), 'project_id' => $project->id, 'title' => $project->title]);

        return redirect()->route('admin.projects.index')
            ->with('success', "Project \"{$project->title}\" created.");
    }

    public function edit(Project $project): View
    {
        $skillTags      = SkillTag::orderBy('category')->orderBy('name')->get()->groupBy('category');
        $statuses       = ProjectStatus::cases();
        $selectedSkills = $project->skillTags->pluck('id')->toArray();

        return view('admin.projects.edit', compact('project', 'skillTags', 'statuses', 'selectedSkills'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $request->validate([
            'title'            => 'required|string|max:120',
            'slug'             => "required|string|max:120|unique:projects,slug,{$project->id}|alpha_dash",
            'description'      => 'required|string',
            'long_description' => 'nullable|string',
            'repo_url'         => 'nullable|url|max:255',
            'live_url'         => 'nullable|url|max:255',
            'status'           => 'required|in:draft,published,archived',
            'display_order'    => 'integer|min:0',
            'skill_tags'       => 'nullable|array',
            'skill_tags.*'     => 'integer|exists:skill_tags,id',
            'images'           => 'nullable|array',
            'images.*'         => 'image:jpeg,png,webp,gif|max:1536',
            'delete_images'    => 'nullable|array',
            'delete_images.*'  => 'integer|exists:project_images,id',
            'image_order'      => 'nullable|array',
            'image_order.*'    => 'integer',
        ]);

        $project->update($data);
        $project->skillTags()->sync($data['skill_tags'] ?? []);

        // Delete marked images
        foreach ($data['delete_images'] ?? [] as $imageId) {
            $image = $project->images()->find($imageId);
            if ($image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
        }

        // Reorder remaining images
        foreach ($data['image_order'] ?? [] as $position => $imageId) {
            $project->images()->where('id', $imageId)->update(['order' => $position]);
        }

        $this->storeImages($request, $project);

        Log::info('Project updated', ['user_id' => auth()->id(), 'project_id' => $project->id, 'title' => $project->title]);

        return redirect()->route('admin.projects.edit', $project)
            ->with('success', "Project \"{$project->title}\" updated.");
    }

    public function destroyImage(Project $project, ProjectImage $image): RedirectResponse
    {
        abort_if($image->project_id !== $project->id, 404);

        Storage::disk('public')->delete($image->path);
        $image->delete();

        return redirect()->route('admin.projects.edit', $project)
            ->with('success', 'Image removed.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $title = $project->title;
        $id    = $project->id;
        $project->delete();

        Log::warning('Project deleted', ['user_id' => auth()->id(), 'project_id' => $id, 'title' => $title]);

        return redirect()->route('admin.projects.index')
            ->with('success', "Project \"{$title}\" deleted.");
    }

    public function syncGithub(Project $project): RedirectResponse
    {
        $synced = $this->github->syncProject($project);

        $message = $synced
            ? "GitHub stats synced for \"{$project->title}\"."
            : "Could not sync GitHub stats — check the repo URL and GITHUB_TOKEN.";

        return redirect()->route('admin.projects.index')
            ->with($synced ? 'success' : 'error', $message);
    }

    private function storeImages(Request $request, Project $project): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $order = $project->images()->max('order') ?? -1;

        foreach ($request->file('images') as $file) {
            $path = $file->store("projects/{$project->id}", 'public');
            $project->images()->create(['path' => $path, 'order' => ++$order]);
        }
    }
}
