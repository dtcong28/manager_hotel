<?php

namespace App\Repositories\Eloquent;

use App\Models\Food;

class FoodRepository extends CustomRepository
{
    protected $model = Food::class;

    public function __construct()
    {
        parent::__construct();
    }
}
