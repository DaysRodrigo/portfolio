<?php

declare(strict_types=1);

use App\Services\GitHubService;
use App\Models\Project;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->service = new GitHubService();
});

it('extracts repo path from github https url', function () {
    $extract = (new ReflectionMethod(GitHubService::class, 'extractRepoPath'))
        ->getClosure($this->service);

    expect($extract('https://github.com/owner/repo'))->toBe('owner/repo')
        ->and($extract('https://github.com/owner/repo.git'))->toBe('owner/repo')
        ->and($extract('https://github.com/owner/repo/tree/main'))->toBe('owner/repo');
});

it('returns null for non-github url', function () {
    $extract = (new ReflectionMethod(GitHubService::class, 'extractRepoPath'))
        ->getClosure($this->service);

    expect($extract('https://gitlab.com/owner/repo'))->toBeNull()
        ->and($extract(null))->toBeNull()
        ->and($extract(''))->toBeNull();
});

it('syncs github stats and caches the result', function () {
    $project = Project::factory()->create([
        'repo_url'      => 'https://github.com/owner/repo',
        'github_stars'  => 0,
        'github_forks'  => 0,
    ]);

    Http::fake([
        'api.github.com/repos/owner/repo' => Http::response([
            'stargazers_count' => 42,
            'forks_count'      => 7,
            'pushed_at'        => '2026-01-01T00:00:00Z',
        ], 200),
    ]);

    $result = $this->service->syncProject($project);

    expect($result)->toBeTrue();
    expect($project->fresh()->github_stars)->toBe(42);
    expect($project->fresh()->github_forks)->toBe(7);
    expect(Cache::has('github:owner/repo'))->toBeTrue();
});

it('returns false when project has no repo url', function () {
    $project = Project::factory()->create(['repo_url' => null]);

    $result = $this->service->syncProject($project);

    expect($result)->toBeFalse();
});

it('returns false on github api error', function () {
    $project = Project::factory()->create([
        'repo_url' => 'https://github.com/owner/repo',
    ]);

    Http::fake([
        'api.github.com/repos/owner/repo' => Http::response([], 404),
    ]);

    Cache::forget('github:owner/repo');

    $result = $this->service->syncProject($project);

    expect($result)->toBeFalse();
});
