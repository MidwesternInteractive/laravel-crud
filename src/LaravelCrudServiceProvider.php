<?php

namespace MWI\LaravelCrud;

use Illuminate\Support\ServiceProvider;

class LaravelCrudServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\Crud::class,
            ]);
        }
    }
}
