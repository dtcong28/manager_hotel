<?php

namespace App\Repositories\Eloquent;

use App\Models\Hotel;

class HotelRepository extends CustomRepository
{
    protected $model = Hotel::class;

    public function __construct()
    {
        parent::__construct();
    }
}
