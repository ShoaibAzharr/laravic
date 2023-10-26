<?php

namespace WhiteFalcon\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public $bindings = [
        'kernel' => '\WhiteFalcon\Services\Kernel',
        'proxy' => '\WhiteFalcon\Proxies\Proxy'
    ];
}