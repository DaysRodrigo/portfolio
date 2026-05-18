<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->unique()->words(3, true);

        return [
            'title'            => ucwords($title),
            'slug'             => Str::slug($title),
            'description'      => $this->faker->sentence(),
            'long_description' => null,
            'repo_url'         => null,
            'live_url'         => null,
            'cover_image'      => null,
            'status'           => ProjectStatus::Draft,
            'display_order'    => 0,
            'tech_stack'       => null,
            'github_stars'     => 0,
            'github_forks'     => 0,
            'github_last_push' => null,
            'github_synced_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(['status' => ProjectStatus::Published]);
    }
}
