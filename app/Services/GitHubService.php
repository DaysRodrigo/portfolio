<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GitHubService
{
    private const CACHE_TTL = 3600; // 1 hour

    public function syncProject(Project $project): bool
    {
        $repoPath = $this->extractRepoPath($project->repo_url);

        if (! $repoPath) {
            return false;
        }

        $data = Cache::remember("github:{$repoPath}", self::CACHE_TTL, fn () => $this->fetchRepo($repoPath));

        if (! $data) {
            return false;
        }

        $project->update([
            'github_stars'     => $data['stargazers_count'] ?? 0,
            'github_forks'     => $data['forks_count'] ?? 0,
            'github_last_push' => isset($data['pushed_at']) ? now()->parse($data['pushed_at']) : null,
            'github_synced_at' => now(),
        ]);

        return true;
    }

    private function fetchRepo(string $repoPath): ?array
    {
        try {
            $response = Http::withToken(config('services.github.token'))
                ->timeout(10)
                ->get("https://api.github.com/repos/{$repoPath}");

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning("GitHub API returned {$response->status()} for {$repoPath}");
        } catch (\Throwable $e) {
            Log::error("GitHub API error for {$repoPath}: {$e->getMessage()}");
        }

        return null;
    }

    private function extractRepoPath(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        // Validate it is a well-formed URL pointing strictly to github.com (SSRF prevention)
        $parsed = parse_url($url);

        if (
            ! isset($parsed['host']) ||
            ! in_array(strtolower($parsed['host']), ['github.com', 'www.github.com'], strict: true) ||
            ! in_array($parsed['scheme'] ?? '', ['https', 'http'], strict: true)
        ) {
            Log::warning('GitHubService: rejected non-GitHub URL', ['url' => $url]);

            return null;
        }

        if (preg_match('#github\.com/([a-zA-Z0-9_.\-]+/[a-zA-Z0-9_.\-]+?)(?:\.git)?(?:/.*)?$#', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
