<?php

namespace WhiteFalcon\Interfaces;

interface CoreClassesProxiesInterface
{

    const CORE_CLASSES_PROXIES = [
        'Illuminate\Routing\Controller' => [
            'WhiteFalcon\Decorators\Controllers\BaseController'
        ],
        'WhiteFalcon\Traits\BlackMagic' => [
            'WhiteFalcon\Decorators\Controllers\WhiteMagic' 
        ],
        'WhiteFalcon\Decorators\Controllers\Controller' => [ 
            'App\Http\Controllers\WFController'
        ],
        'Illuminate\Foundation\Auth\User' => [ 
            'WhiteFalcon\Decorators\Models\User'
        ],
        'WhiteFalcon\Traits\RedMagic' => [ 
            'WhiteFalcon\Decorators\Models\WhiteMagic'
        ],
        'WhiteFalcon\Decorators\Models\Authenticatable' => [ 
            'App\Models\WFAuthenticatable'
        ],
        'Illuminate\Database\Eloquent\Model' => [ 
            'WhiteFalcon\Decorators\Models\BaseModel'
        ],
        'WhiteFalcon\Decorators\Models\Model' => [ 
            'App\Models\WFModel'
        ],
        'Illuminate\Http\Resources\Json\JsonResource' => [
            'WhiteFalcon\Decorators\Resources\BaseJsonResource'
        ],
        'WhiteFalcon\Traits\GreenMagic' => [
            'WhiteFalcon\Decorators\Resources\WhiteMagic' 
        ],
        'WhiteFalcon\Decorators\Resources\JsonResource' => [
            'App\Http\Resources\WFJsonResource'
        ],
        'WhiteFalcon\Repositories\Repository' => [
            'WhiteFalcon\Decorators\Repositories\BaseRepository'
        ],
        'WhiteFalcon\Traits\BlueMagic' => [
            'WhiteFalcon\Decorators\Repositories\WhiteMagic' 
        ],
        'WhiteFalcon\Decorators\Repositories\Repository' => [
            'App\Repositories\Repository'
        ],
        'Illuminate\Foundation\Console\ModelMakeCommand' => [
            'WhiteFalcon\Decorators\Commands\BaseModelMakeCommand'
        ],
        'WhiteFalcon\Traits\GreyMagic' => [
            'WhiteFalcon\Decorators\Commands\WhiteMagic' 
        ],
    ];

}