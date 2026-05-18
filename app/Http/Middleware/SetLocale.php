<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private const SUPPORTED_LOCALES = ['en', 'pt_BR'];
    private const COOKIE_NAME       = 'app_locale';

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->cookie(self::COOKIE_NAME);

        if ($locale && in_array($locale, self::SUPPORTED_LOCALES, strict: true)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
