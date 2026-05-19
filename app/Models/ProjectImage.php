<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectImage extends Model
{
    protected $fillable = ['project_id', 'path', 'alt', 'order'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
