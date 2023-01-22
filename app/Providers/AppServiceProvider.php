<?php

namespace App\Providers;

use Inertia\ResponseFactory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\Arrayable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // ResponseFactory::macro('modal', function (
        //     string $component,
        //     array|Arrayable $props = []
        // ) {
        //     return new Modal($component, $props);
        // });
    }
}
