<?php

declare(strict_types=1);

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\User;

// --- Auth guard ---

it('admin index redirects guest to login', function () {
    $this->get('/admin/projects')->assertRedirect('/login');
});

it('admin create redirects guest to login', function () {
    $this->get('/admin/projects/create')->assertRedirect('/login');
});

// --- Authenticated access ---

it('admin index is accessible to authenticated user', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/admin/projects')
        ->assertOk();
});

it('admin can create a project', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post('/admin/projects', [
            'title'         => 'My Project',
            'slug'          => 'my-project',
            'description'   => 'A test project.',
            'status'        => 'draft',
            'display_order' => 0,
        ])
        ->assertRedirect('/admin/projects');

    $this->assertDatabaseHas('projects', ['slug' => 'my-project']);
});

it('admin create validates required fields', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post('/admin/projects', [])
        ->assertSessionHasErrors(['title', 'slug', 'description', 'status']);
});

it('admin can update a project', function () {
    $user    = User::factory()->create();
    $project = Project::factory()->create(['title' => 'Old Title', 'slug' => 'old-title']);

    $this->actingAs($user)
        ->put("/admin/projects/{$project->id}", [
            'title'         => 'New Title',
            'slug'          => 'new-title',
            'description'   => 'Updated.',
            'status'        => 'published',
            'display_order' => 1,
        ])
        ->assertRedirect("/admin/projects/{$project->id}/edit");

    expect($project->fresh()->title)->toBe('New Title');
});

it('admin can delete a project', function () {
    $user    = User::factory()->create();
    $project = Project::factory()->create();

    $this->actingAs($user)
        ->delete("/admin/projects/{$project->id}")
        ->assertRedirect('/admin/projects');

    $this->assertDatabaseMissing('projects', ['id' => $project->id]);
});

it('slug must be unique on create', function () {
    $user = User::factory()->create();
    Project::factory()->create(['slug' => 'taken-slug']);

    $this->actingAs($user)
        ->post('/admin/projects', [
            'title'       => 'Another',
            'slug'        => 'taken-slug',
            'description' => 'Desc',
            'status'      => 'draft',
        ])
        ->assertSessionHasErrors('slug');
});
