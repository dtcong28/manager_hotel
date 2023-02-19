<?php

namespace App\Repositories\Eloquent;

use App\Models\BookingRoom;

class BookingRoomRepository extends CustomRepository
{
    protected $model = BookingRoom::class;

    public function __construct()
    {
        parent::__construct();
    }
}
