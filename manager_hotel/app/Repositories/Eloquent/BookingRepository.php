<?php

namespace App\Repositories\Eloquent;

use App\Models\Booking;
use App\Models\Enums\BookingStatusEnum;

class BookingRepository extends CustomRepository
{
    protected $model = Booking::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function getSearchBooking($params)
    {
        $query = $this->select('booking.id', 'booking.time_check_in', 'booking.time_check_out', 'booking.status_payment', 'booking.status_booking', 'customers.name', 'customers.email', 'customers.phone')
            ->join('customers', 'customers.id', 'booking.customer_id')
            ->where('customers.name', 'LIKE', '%' . $params . '%')
            ->orWhere('customers.phone', 'LIKE', '%' . $params . '%')
            ->orWhere('customers.email', 'LIKE', '%' . $params . '%')
            ->orWhere('booking.time_check_in', 'LIKE', '%' . $params . '%')
            ->orWhere('booking.time_check_out', 'LIKE', '%' . $params . '%')->orderBy('id','desc');
//            ->when(str_contains('unpaid', $params), function ($q) {
//                $q->orWhere('booking.status_payment', '=', 0);
//            })
//            ->when(str_contains('paid', $params), function ($q) {
//                $q->orWhere('booking.status_payment', '=', 1);
//            });

        return $query->paginate(getConfig('page_number'));
    }

    public function getDetailBooking($id)
    {
        $params['sort'] = 'id';
        $params['direction'] = 'desc';
        $params['id_eq'] = $id;

        return $this->search($params)->with(['bookingRoom', 'bookingRoom.room', 'customer'])->first();
    }

    public function getListBookingByRoom($roomId, $bookingId)
    {
        $query = $this->select('booking.id', 'booking.time_check_in', 'booking.time_check_out')
            ->join('booking_rooms', 'booking_rooms.booking_id', 'booking.id')
            ->where('booking.status_booking', '!=', BookingStatusEnum::CHECK_OUT->value)
            ->where('booking_rooms.room_id', '=', $roomId)
            ->where('booking.id', '!=', $bookingId);

        return $query->get()->toArray();
    }
}
