<?php

declare(strict_types=1);

namespace App\Enums;

enum SkillCategory: string
{
    case Backend  = 'backend';
    case Frontend = 'frontend';
    case DevOps   = 'devops';
    case Database = 'database';
    case Tools    = 'tools';

    public function label(): string
    {
        return match($this) {
            self::Backend  => 'Backend',
            self::Frontend => 'Frontend',
            self::DevOps   => 'DevOps',
            self::Database => 'Banco de Dados',
            self::Tools    => 'Ferramentas',
        };
    }
}
