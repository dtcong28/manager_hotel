<?php

namespace App\Repositories\Eloquent;

use App\Models\BookingRoom;
use App\Models\Room;
use Illuminate\Support\Facades\Session;
use App\Models\Enums\RoomStatusEnum;

class RoomRepository extends CustomRepository
{
    protected $model = Room::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function getListRoomInRangeTimeBooking($checkIn, $checkOut)
    {
        $query = BookingRoom::select('booking_rooms.room_id')->join('booking', 'booking_rooms.booking_id', 'booking.id')
            ->whereNot(function ($q) use ($checkIn, $checkOut) {
                $q->where('booking.time_check_out', '<=', $checkIn)
                    ->orWhere('booking.time_check_in', '>=', $checkOut);
            });
        return $query->get();
    }

    public function getListFilterRoom($data)
    {
        $results = [];
        $roomInRangeTimeBooking = $this->getListRoomInRangeTimeBooking($data['time_check_in'], $data['time_check_out']);

        foreach ($data['number_people'] as $key => $value) {
            $filterRoom = $this->where('number_people', '=', $value)->whereNotIn('id', $roomInRangeTimeBooking)->with(['typeRoom'])->get();
            if ($filterRoom->isNotEmpty()) {
                foreach ($filterRoom as $index => $item) {
                    $item->image = $item->getMedia('images')[0]->getUrl();
                    $results[$key][$index] = $item;
                }
            } else {
                $results[$key] = [];
            }

        }

        return $results;
    }

    public function getDetailRoom($id)
    {
        $data['sort'] = empty($params['sort']) ? 'id' : $params['sort'];
        $data['direction'] = empty($params['direction']) ? 'desc' : $params['direction'];
        $data['id_eq'] = $id;

        return $this->search($data)->first();
    }

    public function getListSelectRoom($params)
    {
        $data['sort'] = empty($params['sort']) ? 'id' : $params['sort'];
        $data['direction'] = empty($params['direction']) ? 'desc' : $params['direction'];

        foreach ($params as $key => $param) {
            $data['id_eq'] = $param;
            $query[$key] = $this->search($data)->first()->toArray();
        }

        return $query;
    }

    public function getSearchRoom($params)
    {
        $query = $this->select()
            ->where('name', 'LIKE', '%' . $params . '%')
            ->orWhere('number_people', 'LIKE', '%' . $params . '%')
            ->orWhere('number_bed', 'LIKE', '%' . $params . '%')
            ->orWhere('rent_per_night', 'LIKE', '%' . $params . '%')
            ->when(!empty($params), function ($q) use ($params) {
                foreach (RoomStatusEnum::cases() as $data) {
                    if(str_contains(strtolower($data->name), strtolower($params))){
                        $q->orWhere('status', '=', $data->value);
                    }
                }
            })
            ->orderBy('id', 'desc');

        return $query->with(['typeRoom'])->paginate(getConfig('page_number'));
    }

    public function getSearchWebRoom($params)
    {
        $query = $this
            ->when(empty($params['time_check_in']) && empty($params['time_check_out']), function ($query) {
                $query->where('status', '=', \App\Models\Enums\RoomStatusEnum::VACANT->value);
            })
            ->when(!empty($params['time_check_in']) && !empty($params['time_check_out']), function ($query) use ($params) {
                $roomInRangeTimeBooking = $this->getListRoomInRangeTimeBooking($params['time_check_in'], $params['time_check_out']);
                $query->whereNotIn('id', $roomInRangeTimeBooking);
            })
            ->when(!empty($params['number_people']), function ($query) use ($params) {
                $query->where('number_people', '=', $params['number_people']);
            })
            ->when(!empty($params['type_room']), function ($query) use ($params) {
                $query->where('type_room_id', '=', $params['type_room']);
            });

        return $query->get();
    }
}
