<?php

namespace App\Repositories;

use App\Models\Service;

class ServiceRepository extends Repository
{
    /**
     * @return class
     */
    public function model()
    {
        return Service::class;
    }
}