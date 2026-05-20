<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TimelineType;
use Illuminate\Database\Eloquent\Model;

class TimelineEntry extends Model
{
    protected $fillable = [
        'type',
        'title',
        'organization',
        'location',
        'start_date',
        'end_date',
        'description',
        'skills',
        'display_order',
    ];

    protected $casts = [
        'type'          => TimelineType::class,
        'start_date'    => 'date',
        'end_date'      => 'date',
        'skills'        => 'array',
        'display_order' => 'integer',
    ];

    public function isPresent(): bool
    {
        return $this->end_date === null;
    }
}
