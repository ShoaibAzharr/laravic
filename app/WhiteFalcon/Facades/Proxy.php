<?php
namespace WhiteFalcon\Facades;

use Illuminate\Support\Facades\Facade;

class Proxy extends Facade {
    
    protected static function getFacadeAccessor() 
    {
	    return 'proxy';
    }
}