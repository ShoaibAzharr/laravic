<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use WhiteFalcon\Contracts\FillableFromRequest;

class Service extends WFModel implements FillableFromRequest
{
    use HasFactory;
}
