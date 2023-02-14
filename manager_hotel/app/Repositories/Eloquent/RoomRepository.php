<?php

namespace App\Repositories\Eloquent;

use App\Models\Room;

class RoomRepository extends CustomRepository
{
    protected $model = Room::class;

    public function __construct()
    {
        parent::__construct();
    }
}
