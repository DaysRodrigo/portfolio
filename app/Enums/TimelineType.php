<?php

declare(strict_types=1);

namespace App\Enums;

enum TimelineType: string
{
    case Work      = 'work';
    case Education = 'education';

    public function label(): string
    {
        return match($this) {
            self::Work      => 'Work',
            self::Education => 'Education',
        };
    }
}
