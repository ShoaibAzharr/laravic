<?php

namespace WhiteFalcon\Proxies;

use WhiteFalcon\Interfaces\ProxyInterface;

final class Proxy implements ProxyInterface
{
    public function boot() : Void
    {
        LoadProxy::start();
    }
}
