<?php

declare(strict_types=1);

use App\Models\Project;
use App\Enums\ProjectStatus;

it('home page returns 200', function () {
    $this->get('/')->assertOk();
});

it('home page shows published projects', function () {
    $published = Project::factory()->create(['status' => ProjectStatus::Published]);
    $draft     = Project::factory()->create(['status' => ProjectStatus::Draft]);

    $this->get('/')
        ->assertOk()
        ->assertSee($published->title)
        ->assertDontSee($draft->title);
});

it('home page shows timeline section', function () {
    $this->get('/')->assertOk()->assertSee('id="about"', false);
});

it('home page shows skills section', function () {
    $this->get('/')->assertOk()->assertSee('id="skills"', false);
});

it('home page shows projects section', function () {
    $this->get('/')->assertOk()->assertSee('id="projects"', false);
});
