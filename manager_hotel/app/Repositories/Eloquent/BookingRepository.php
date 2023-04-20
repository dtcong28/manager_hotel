<?php

namespace App\Repositories\Eloquent;

use App\Models\Booking;
use App\Models\Enums\PaymentStatusEnum;
use App\Models\Enums\BookingStatusEnum;
use Illuminate\Support\Facades\DB;

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
            ->orWhere('booking.time_check_out', 'LIKE', '%' . $params . '%')->orderBy('id', 'desc')
            ->when(!empty($params), function ($q) use ($params) {
                foreach (PaymentStatusEnum::cases() as $data) {
                    if (str_contains(strtolower($data->name), strtolower($params))) {
                        $q->orWhere('status_payment', '=', $data->value);
                    }
                }
            })
            ->when(!empty($params), function ($q) use ($params) {
                foreach (BookingStatusEnum::cases() as $data) {
                    if (str_contains(strtolower(BookingStatusEnum::statusLabel($data->value)), strtolower($params))) {
                        $q->orWhere('status_booking', '=', $data->value);
                    }
                }
            });

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

    public function getListCheckIn()
    {
        $params = [
            'status_booking_eq' => BookingStatusEnum::CHECK_IN->value,
            'sort' => 'id',
            'direction' => 'desc',
        ];

        return $this->search($params)->get();
    }

    public function getListCheckOut()
    {
        $params = [
            'status_booking_eq' => BookingStatusEnum::CHECK_OUT->value,
            'sort' => 'id',
            'direction' => 'desc',
        ];

        return $this->search($params)->get();
    }

    public function getListEA()
    {
        $params = [
            'status_booking_eq' => BookingStatusEnum::EXPECTED_ARRIVAL->value,
            'sort' => 'id',
            'direction' => 'desc',
        ];

        return $this->search($params)->get();
    }

    public function getTotalMoney(){
        return $this->select(DB::raw('sum(total_money) as total_money'))->where('status_payment', '=', PaymentStatusEnum::PAID->value)->first();
    }
}
