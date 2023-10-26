<?php

namespace WhiteFalcon\Interfaces;

interface LoadProxyInterface extends CoreClassesProxiesInterface 
{

    public static function start(): Void;
    
    public function core(): Void;

}