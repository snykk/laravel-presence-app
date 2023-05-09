<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AcceptLocale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $localeKeys = \I18n::getLocaleKeys();
        $locale = $request->segment(2);

        if (!in_array($locale, $localeKeys)) { /** @phpstan-ignore-line */
            abort(404);
        }

        app()->setlocale($locale); /** @phpstan-ignore-line */

        return $next($request);
    }
}
