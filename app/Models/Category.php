<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use WhiteFalcon\Contracts\FillableFromRequest;

class Category extends WFModel implements FillableFromRequest
{
    use HasFactory;

    // protected $fillable = [
    //     'name',
    //     'user_id'
    // ];

    public static $BelongsTo = [
        'user'
    ];

    
}
