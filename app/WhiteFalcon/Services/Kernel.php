<?php

namespace WhiteFalcon\Services;

use WhiteFalcon\Console\Commands\Command;
use WhiteFalcon\Interfaces\AppInterface;
use WhiteFalcon\Facades\Proxy;

final class Kernel implements AppInterface
{
    public function initialize($provider) : Void
    {
        Command::boot($provider);
        Proxy::boot();
    }
}
