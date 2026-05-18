<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\SkillTag;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    public function run(): void
    {
        $salus = Project::updateOrCreate(
            ['slug' => 'salus-totalis'],
            [
                'title'            => 'Salus Totalis',
                'description'      => 'Multi-tenant SaaS for clinical management. Built from scratch as a real commercial product for clinics of any specialty.',
                'long_description' => 'Salus Totalis is a multi-tenant SaaS platform for clinical management, built from scratch as a real commercial product. It serves clinics of any specialty (physiotherapy, psychology, nutrition, dentistry, etc.) and was designed for scalability from day one. Features include RBAC with 5 hierarchical roles, patient management, professional profiles, weekly schedule with real-time slot calculation, appointment booking with conflict validation, medical records with configurable fields per tenant, financial records, Stripe billing with trial period, and LGPD data portability.',
                'repo_url'         => null,
                'live_url'         => null,
                'cover_image'      => null,
                'status'           => ProjectStatus::Published,
                'display_order'    => 1,
                'tech_stack'       => ['PHP 8.5', 'Laravel 12', 'MySQL 8.4', 'Redis', 'Filament v5', 'Livewire v3', 'Stripe', 'Docker', 'Pest v3'],
            ]
        );

        $skills = SkillTag::whereIn('name', [
            'PHP', 'Laravel', 'MySQL', 'Redis', 'Docker', 'Pest', 'Linux',
        ])->pluck('id');

        $salus->skillTags()->sync($skills);
    }
}
