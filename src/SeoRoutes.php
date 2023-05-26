<?php

namespace Codedor\Seo;

use Codedor\Seo\Facades\SeoBuilder;
use Codedor\Seo\Http\Middleware\SeoMiddleware;
use Codedor\Seo\Models\SeoRoute;
use Codedor\Seo\Tags\Meta;
use Codedor\Seo\Tags\OpenGraph;
use Codedor\Seo\Tags\OpenGraphImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class SeoRoutes
{
    public static function list()
    {
        $routeCollection = Route::getRoutes();

        $routes = collect($routeCollection)
            ->filter(function ($route) {
                if (empty($route->action['as']) ||
                    empty($route->action['uses']) ||
                    empty($route->action['middleware'])
                ) {
                    return false;
                }

                $middleware = $route->action['middleware'];

                return in_array('seo', $middleware)
                    || in_array(SeoMiddleware::class, $middleware);
            })
            ->map(function ($route) {
                $routeName = $route->action['as'] ?? '';

                $routeMiddleware = $route->action['middleware'] ?? [];

                return [
                    'as' => $routeName,
                    'methods' => $route->methods,
                    'action' => $route->action['uses'] ?? '',
                    'middleware' => $routeMiddleware,
                ];
            });

        return $routes;
    }

    public static function build(SeoRoute $seoRoute, ?Model $entity)
    {
        $tags = [
            [
                'type' => OpenGraph::class,
                'name' => 'type',
                'content' => $seoRoute->og_type,
            ],
            [
                'type' => OpenGraphImage::class,
                'name' => 'image',
                'content' => $seoRoute->og_image,
            ],
            [
                'type' => OpenGraph::class,
                'name' => 'title',
                'content' => self::fillPlaceholders($seoRoute->og_title, $entity),
            ],
            [
                'type' => OpenGraph::class,
                'name' => 'description',
                'content' => self::fillPlaceholders($seoRoute->og_description, $entity),
            ],
            [
                'type' => Meta::class,
                'name' => 'title',
                'content' => self::fillPlaceholders($seoRoute->meta_title, $entity),
            ],
            [
                'type' => Meta::class,
                'name' => 'description',
                'content' => self::fillPlaceholders($seoRoute->meta_description, $entity),
            ],
        ];

        SeoBuilder::tags($tags);
    }

    public static function fillPlaceholders(?string $text, ?Model $entity)
    {
        if (! $entity) {
            return $text;
        }

        $text = preg_replace_callback('/{{ (?<keyword>.*?) }}/', function ($match) use ($entity) {
            $found = data_get($entity, $match['keyword']);
            if ($found) {
                return strip_tags($found);
            }
        }, $text);

        return $text;
    }
}
