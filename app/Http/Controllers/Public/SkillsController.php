<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\SkillTag;

class SkillsController extends Controller
{
    public function index()
    {
        $skills = SkillTag::all()->groupBy('category');

        return view('public.skills', compact('skills'));
    }
}
