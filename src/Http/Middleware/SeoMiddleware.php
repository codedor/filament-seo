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
        $entity = collect($request->route()->parameters)->filter(function ($entity) {
            return $entity instanceof Model;
        })->last();

        $seoRoute = SeoRoute::whereRoute($request->route()->getName())
            ->first();

        if ($seoRoute) {
            SeoRoutes::build($seoRoute, $entity);
        }

        return $next($request);
    }
}
