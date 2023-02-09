<?php

namespace App\Repositories\Eloquent;

use App\Models\TypeRoom;

class TypeRoomRepository extends CustomRepository
{
    protected $model = TypeRoom::class;

    public function __construct()
    {
        parent::__construct();
    }
}
