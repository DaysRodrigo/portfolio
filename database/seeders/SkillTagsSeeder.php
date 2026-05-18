<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\SkillTag;
use Illuminate\Database\Seeder;

class SkillTagsSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            'backend'  => ['PHP', 'Laravel', 'REST API', 'Pest', 'PHPStan'],
            'frontend' => ['Tailwind CSS', 'Alpine.js', 'Blade', 'Vite'],
            'devops'   => ['Docker', 'Docker Compose', 'GitHub Actions', 'Railway', 'Linux', 'Nginx'],
            'database' => ['MySQL', 'Redis', 'Eloquent ORM'],
            'tools'    => ['Git', 'VS Code', 'Postman'],
        ];

        foreach ($skills as $category => $names) {
            foreach ($names as $name) {
                SkillTag::updateOrCreate(
                    ['name' => $name],
                    ['category' => $category]
                );
            }
        }
    }
}
