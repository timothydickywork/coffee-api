<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\Fractal\ScopeFactoryInterface;
use League\Fractal\ScopeFactory;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ScopeFactoryInterface::class, ScopeFactory::class);
    }
}
