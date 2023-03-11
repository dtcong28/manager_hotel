<?php

namespace App\Repositories\Eloquent;

use App\Models\BookingFood;

class BookingFoodRepository extends CustomRepository
{
    protected $model = BookingFood::class;

    public function __construct()
    {
        parent::__construct();
    }
}
