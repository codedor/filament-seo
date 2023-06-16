<?php

use Codedor\Seo\Facades\SeoBuilder;
use Codedor\Seo\Http\Middleware\SeoMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

it('will not the seo routes if no route is found', function () {
    Route::get('', fn () => 'route');

    SeoBuilder::shouldReceive('build')
        ->never();

    app(SeoMiddleware::class)->handle(Request::create(''), fn() => '');
});

it('will build the seo routes when route matches', function () {
    Route::get('test', fn () => 'route');

    SeoBuilder::shouldReceive('build')
        ->once();

    $symfonyRequest = HttpFoundationRequest::create(
        'test', 'GET'
    );

    $request = Request::createFromBase($symfonyRequest);

    app(SeoMiddleware::class)->handle($request, fn() => '');
})->todo('see how middleware can be tested');
