<?php

namespace Codedor\Seo\Http\Middleware;

use Closure;
use Codedor\Seo\Models\SeoRoute;
use Codedor\Seo\SeoRoutes;
use Illuminate\Database\Eloquent\Model;

class SeoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route = $request->route();

        if (! $route) {
            return $next($request);
        }

        $entity = collect($route->parameters)
            ->filter(fn ($entity) => $entity instanceof Model)
            ->last();

        $seoRoute = SeoRoute::where('route', $route->getName())
            ->first();

        if ($seoRoute) {
            SeoRoutes::build($seoRoute, $entity);
        }

        return $next($request);
    }
}
