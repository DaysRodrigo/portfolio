<?php

declare(strict_types=1);

use App\Models\Project;
use App\Enums\ProjectStatus;

it('home page returns 200', function () {
    $this->get('/')->assertOk();
});

it('projects index returns 200', function () {
    $this->get('/projects')->assertOk();
});

it('skills page returns 200', function () {
    $this->get('/skills')->assertOk();
});

it('timeline page returns 200', function () {
    $this->get('/timeline')->assertOk();
});

it('project detail returns 200 for published project', function () {
    $project = Project::factory()->create([
        'status' => ProjectStatus::Published,
        'slug'   => 'test-project',
    ]);

    $this->get("/projects/{$project->slug}")->assertOk();
});

it('project detail returns 404 for draft project', function () {
    $project = Project::factory()->create([
        'status' => ProjectStatus::Draft,
        'slug'   => 'hidden-project',
    ]);

    $this->get("/projects/{$project->slug}")->assertNotFound();
});

it('project detail returns 404 for unknown slug', function () {
    $this->get('/projects/does-not-exist')->assertNotFound();
});
