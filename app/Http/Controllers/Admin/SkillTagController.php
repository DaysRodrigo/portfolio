<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\SkillCategory;
use App\Http\Controllers\Controller;
use App\Models\SkillTag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SkillTagController extends Controller
{
    public function index(): View
    {
        $skillTags = SkillTag::orderBy('category')->orderBy('name')->get()->groupBy('category');

        return view('admin.skill-tags.index', compact('skillTags'));
    }

    public function create(): View
    {
        $categories = SkillCategory::cases();

        return view('admin.skill-tags.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => 'required|string|max:60|unique:skill_tags,name',
            'category' => ['required', Rule::enum(SkillCategory::class)],
        ]);

        $tag = SkillTag::create($data);

        Log::info('SkillTag created', ['user_id' => auth()->id(), 'skill_tag_id' => $tag->id, 'name' => $tag->name]);

        return redirect()->route('admin.skill-tags.index')
            ->with('success', "Skill \"{$tag->name}\" created.");
    }

    public function edit(SkillTag $skillTag): View
    {
        $categories = SkillCategory::cases();

        return view('admin.skill-tags.edit', compact('skillTag', 'categories'));
    }

    public function update(Request $request, SkillTag $skillTag): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:60', Rule::unique('skill_tags', 'name')->ignore($skillTag->id)],
            'category' => ['required', Rule::enum(SkillCategory::class)],
        ]);

        $skillTag->update($data);

        Log::info('SkillTag updated', ['user_id' => auth()->id(), 'skill_tag_id' => $skillTag->id, 'name' => $skillTag->name]);

        return redirect()->route('admin.skill-tags.index')
            ->with('success', "Skill \"{$skillTag->name}\" updated.");
    }

    public function destroy(SkillTag $skillTag): RedirectResponse
    {
        $name = $skillTag->name;
        $id   = $skillTag->id;
        $skillTag->delete();

        Log::warning('SkillTag deleted', ['user_id' => auth()->id(), 'skill_tag_id' => $id, 'name' => $name]);

        return redirect()->route('admin.skill-tags.index')
            ->with('success', "Skill \"{$name}\" deleted.");
    }
}
