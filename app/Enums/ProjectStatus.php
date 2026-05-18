<?php

declare(strict_types=1);

namespace App\Enums;

enum ProjectStatus: string
{
    case Draft     = 'draft';
    case Published = 'published';
    case Archived  = 'archived';

    public function label(): string
    {
        return match($this) {
            self::Draft     => 'Rascunho',
            self::Published => 'Publicado',
            self::Archived  => 'Arquivado',
        };
    }

    public function isPublic(): bool
    {
        return $this === self::Published;
    }
}
