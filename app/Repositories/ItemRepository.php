<?php

namespace App\Repositories;

use App\Models\Item;

class ItemRepository extends Repository
{
    /**
     * @return class
     */
    public function model()
    {
        return Item::class;
    }
}