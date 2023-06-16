<?php

use Illuminate\Support\Facades\Route;

it('can import seo routes', function () {
    Route::get('test', fn () => 'test')
        ->name('test')
        ->middleware(SeoMiddleware::class);

    $this->artisan('seo:import')->assertExitCode(0);
});
