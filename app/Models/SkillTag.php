<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SkillCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SkillTag extends Model
{
    protected $fillable = [
        'name',
        'category',
    ];

    protected $casts = [
        'category' => SkillCategory::class,
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_skill');
    }

    public function scopeByCategory(Builder $query, SkillCategory $category): Builder
    {
        return $query->where('category', $category);
    }
}
