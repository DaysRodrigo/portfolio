<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->headers->set('Content-Security-Policy', $this->csp());

        if (app()->isProduction()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }

    private function csp(): string
    {
        $vite   = app()->isLocal() ? 'http://localhost:5173 ws://localhost:5173' : '';
        $gfonts = 'https://fonts.googleapis.com https://fonts.gstatic.com';

        return implode('; ', array_filter([
            "default-src 'self'",
            // Alpine.js evaluates x-data/x-on expressions via new Function() which
            // requires 'unsafe-eval'. Removing it breaks Alpine entirely.
            // Mitigation: default-src 'self' prevents loading external scripts.
            "script-src 'self' 'unsafe-inline' 'unsafe-eval'" . ($vite ? " $vite" : ''),
            "style-src 'self' 'unsafe-inline' $gfonts" . ($vite ? " $vite" : ''),
            "img-src 'self' data: https:",
            "font-src 'self' $gfonts",
            "connect-src 'self'" . ($vite ? " $vite" : ''),
            "frame-ancestors 'none'",
        ]));
    }
}
