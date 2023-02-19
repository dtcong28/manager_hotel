<?php

namespace App\Repositories\Eloquent;

use App\Models\Booking;

class BookingRepository extends CustomRepository
{
    protected $model = Booking::class;

    public function __construct()
    {
        parent::__construct();
    }
}
