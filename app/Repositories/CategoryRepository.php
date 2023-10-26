<?php

namespace App\Repositories;

use App\Models\Category;


class CategoryRepository extends Repository
{
    /**
     * @return string
     */
    public function model()
    {
        return Category::class;
    }


    // public function fetchUpdate($query, $requestData, $model){
    //     return 'sdfkljkl';
    // }

    // function fetchIndex($query) {
    //     return 'hey from child class';
    // }

}
