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

    public function getListRoomBooked($param)
    {
        $data['sort'] = empty($params['sort']) ? 'id' : $params['sort'];
        $data['direction'] = empty($params['direction']) ? 'desc' : $params['direction'];
        $data['booking_id_eq'] = $param;

        $query = $this->search($data)->select('id','room_id')->get()->toArray();

        return $query;
    }
}
