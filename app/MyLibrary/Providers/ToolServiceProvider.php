<?php

namespace App\MyLibrary\Providers;

use Illuminate\Support\ServiceProvider;
use App\MyLibrary\ToolFactory;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ToolFactory::class, function () {
            return new ToolFactory();
        });
    }
}
