<?php

namespace App\Repositories;

use App\Models\Area;

class AreaRepository extends Repository
{
    /**
     * @return class
     */
    public function model()
    {
        return Area::class;
    }
}