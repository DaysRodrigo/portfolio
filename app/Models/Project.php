<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Project extends Model
{
    use HasFactory;
    use HasTranslations;

    public array $translatable = ['title', 'description', 'long_description'];
    protected $fillable = [
        'title',
        'slug',
        'description',
        'long_description',
        'repo_url',
        'live_url',
        'cover_image',
        'status',
        'display_order',
        'tech_stack',
        'github_stars',
        'github_forks',
        'github_last_push',
        'github_synced_at',
    ];

    protected $casts = [
        'status'           => ProjectStatus::class,
        'tech_stack'       => 'array',
        'github_last_push' => 'datetime',
        'github_synced_at' => 'datetime',
        'display_order'    => 'integer',
        'github_stars'     => 'integer',
        'github_forks'     => 'integer',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('order');
    }

    public function skillTags(): BelongsToMany
    {
        return $this->belongsToMany(SkillTag::class, 'project_skill');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', ProjectStatus::Published);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('display_order');
    }
}
