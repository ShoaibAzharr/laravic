<?php

namespace WhiteFalcon\Proxies;

use ReflectionClass;
use WhiteFalcon\Interfaces\LoadProxyInterface;

class LoadProxy implements LoadProxyInterface
{
    public static function start(): Void
    {
        (new self)->run();
    }

    private function run()
    {
        $this->core();
    }

    public function core(): Void
    {
        $this->register($this->CORE_CLASSES_PROXIES);
    }

    private function register($classes)
    {
        \array_walk($classes, [$this, 'process']);

    }

    public function __get($name)
    {
        return \property_exists($this, $name) ? $this->{$name} : (new ReflectionClass(get_class($this)))->getConstant($name);
    }


    private function process($proxies, $original)
    {
        \array_walk($proxies, [$this, 'bind'], $original);
    }

    private function bind($proxy, $key, $original)
    {
        \class_exists($proxy) ?: \class_alias($original, $proxy);
    }

}
