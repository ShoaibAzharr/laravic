<?php

namespace WhiteFalcon\Providers;

use WhiteFalcon\App;

class WhiteFalconServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        \array_walk($this->bindings, [$this, 'bind']);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        App::initialize($this);
    }

    /**
     * Bind services.
     */
    public function bind($class, $name): void
    {
        app()->bind($name, fn() => new $class);
    }
}
