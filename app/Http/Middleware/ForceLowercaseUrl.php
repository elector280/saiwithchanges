<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceLowercaseUrl
{
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->getPathInfo(); // includes leading slash
        $lowerPath = strtolower($path);

        if ($path !== $lowerPath) {
            $query = $request->getQueryString();
            $url = $request->getSchemeAndHttpHost() . $lowerPath . ($query ? '?' . $query : '');

            return redirect($url, 301);
        }

        return $next($request);
    }
}