<?php

namespace Codedor\Seo\Http\Middleware;

use Closure;
use Codedor\Seo\Models\SeoRoute;
use Codedor\Seo\SeoRoutes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

        $routeName = $route->getName();
        if (isset($route->wheres['translatable_prefix'])) {
            $routeName = Str::after($routeName, $route->wheres['translatable_prefix'] . '.');
        }

        $seoRoute = SeoRoute::where('route', $routeName)
            ->where('online->' . app()->getLocale(), true)
            ->first();

        if ($seoRoute) {
            SeoRoutes::build($seoRoute, $entity);
        }

        $entity->withSeoFields();

        return $next($request);
    }
}
