<?php

namespace App\Repositories\Eloquent;

use App\Models\Restaurant;

class RestaurantRepository extends CustomRepository
{
    protected $model = Restaurant::class;

    public function __construct()
    {
        parent::__construct();
    }
}
