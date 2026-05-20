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
            'title'       => ['en' => 'My Project'],
            'slug'        => 'my-project',
            'description' => ['en' => 'A test project.'],
            'status'      => 'draft',
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
    // 'title' and 'description' errors fire on the parent key when the array is missing entirely
});

it('admin can update a project', function () {
    $user    = User::factory()->create();
    $project = Project::factory()->create(['title' => ['en' => 'Old Title'], 'slug' => 'old-title']);

    $this->actingAs($user)
        ->put("/admin/projects/{$project->id}", [
            'title'         => ['en' => 'New Title'],
            'slug'          => 'new-title',
            'description'   => ['en' => 'Updated.'],
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
            'title'       => ['en' => 'Another'],
            'slug'        => 'taken-slug',
            'description' => ['en' => 'Desc'],
            'status'      => 'draft',
        ])
        ->assertSessionHasErrors('slug');
});
