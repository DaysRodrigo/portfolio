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
            'backend'  => ['PHP', 'Laravel', 'Node.js', 'REST API', 'Redis'],
            'frontend' => ['JavaScript', 'TypeScript', 'Vue.js', 'Angular', 'Tailwind CSS', 'Alpine.js'],
            'database' => ['MySQL', 'PostgreSQL', 'MongoDB'],
            'devops'   => ['Docker', 'Linux', 'AWS', 'CI/CD', 'GitHub Actions', 'GitLab CI'],
            'tools'    => ['Git', 'Pest', 'PHPUnit', 'Laravel Dusk', 'WordPress', 'Moodle'],
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
