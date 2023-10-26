<?php

namespace App\Repositories;

use App\Models\Teacher;

class TeacherRepository extends Repository
{
    /**
     * @return class
     */
    public function model()
    {
        return Teacher::class;
    }
}