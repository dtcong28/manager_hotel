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

    public function getListBooking($params)
    {
        $query = $this->select('booking.id','booking.time_check_in','booking.time_check_out','booking.status_payment','booking.status_booking', 'customers.name','customers.email','customers.phone')
            ->join('customers', 'customers.id', 'booking.customer_id')
            ->where('customers.name', 'LIKE', '%' . $params . '%')
            ->orWhere('customers.phone', 'LIKE', '%' . $params . '%')
            ->orWhere('customers.email', 'LIKE', '%' . $params . '%')
            ->orWhere('booking.time_check_in', 'LIKE', '%' . $params . '%')
            ->orWhere('booking.time_check_out', 'LIKE', '%' . $params . '%')
            ->when(str_contains('unpaid', $params), function ($q) {
                $q->orWhere('booking.status_payment', '=', 0);
            })
            ->when(str_contains('paid', $params), function ($q) {
                $q->orWhere('booking.status_payment', '=', 1);
            });
//        dd($query->get());
        return $query->paginate(5);
    }

    public function getDetailBooking($id)
    {
        $params['sort'] = 'id';
        $params['direction'] = 'desc';
        $params['id_eq'] = $id;

        return $this->search($params)->with(['bookingRoom','bookingRoom.room', 'customer'])->first();
    }
}
