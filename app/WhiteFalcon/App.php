<?php
namespace WhiteFalcon;

use Illuminate\Support\Facades\Facade;

class App extends Facade {
    
    protected static function getFacadeAccessor() 
    {
	    return 'kernel';
    }
}