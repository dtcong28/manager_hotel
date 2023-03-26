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

    public function getListBooking()
    {
        return $this->with(['bookingRoom', 'customer'])->paginate(5);
//        return $this->where('customer_id', 'LIKE', '%' . $params . '%')->with(['bookingRoom', 'customer'])->paginate(5);
    }

    public function getDetailBooking($id)
    {
        $params['sort'] = 'id';
        $params['direction'] = 'desc';
        $params['id_eq'] = $id;

        return $this->search($params)->with(['bookingRoom','bookingRoom.room', 'customer'])->first();
    }
}
