<?php

use Carbon\Carbon;

if (!function_exists('checkInRange')) {
    function checkInRange($start_date, $end_date, $date)
    {
        return (($date >= $start_date) && ($date < $end_date));
    }
}

if (!function_exists('checkOutRange')) {
    function checkOutRange($start_date, $end_date, $date)
    {
        return (($date > $start_date) && ($date <= $end_date));
    }
}

if (!function_exists('listFilterRoom')) {
    function listFilterRoom($listRoom, $bookedRoom, $checkIn, $checkOut)
    {
        foreach ($listRoom as $index => $rooms) {
            foreach ($rooms as $key => $room) {
                foreach ($bookedRoom as $data) {
                    if ($data['room_id'] == $room['id']) {
                        if ((checkInRange($data['time_check_in'], $data['time_check_out'], $checkIn) || checkOutRange($data['time_check_in'], $data['time_check_out'], $checkOut))) {
                            // Remove elements from array $listRoom at index is $key and re-index:
                            array_splice($listRoom[$index], $key, 1);
                            break;
                        }
                    }
                }
            }
        }

        return $listRoom;
    }
}

if (!function_exists('timeStay')) {
    function timeStay($start, $end)
    {
        $start_date = Carbon::createFromFormat('Y-m-d', $start);
        $end_date = Carbon::createFromFormat('Y-m-d', $end);
        return $start_date->diffInDays($end_date);
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        return date('Y-m-d', strtotime($date));
    }
}

if (!function_exists('formatDataRoom')) {
    function formatDataRoom($data, $roomRepository)
    {
        $rooms = [];
        $roomID = [];
        $roomName = [];
        $roomNumberPeople = [];
        foreach ($data as $value) {
            if (array_key_exists('id', $value)) {
                array_push($roomID, $value);
            }
            if (array_key_exists('name', $value)) {
                array_push($roomName, $value);
            }
            if (array_key_exists('number_people', $value)) {
                array_push($roomNumberPeople, $value);
            }
        }

        foreach ($roomNumberPeople as $key => $value) {
            $rooms[$key] = [
                'id' => array_key_exists($key, $roomID) ? data_get($roomID[$key], 'id') : '',
                'name' => array_key_exists($key, $roomName) ? data_get($roomName[$key], 'name') : '',
                'number_people' => array_key_exists($key, $roomNumberPeople) ? data_get($roomNumberPeople[$key], 'number_people') : '',
                'rent_per_night' => array_key_exists($key, $roomID) ? $roomRepository->getDetailRoom(data_get($roomID[$key], 'id'))->rent_per_night : '',
                'image' => array_key_exists($key, $roomID) ? $roomRepository->getDetailRoom(data_get($roomID[$key], 'id'))->getMedia('images')[0]->getUrl() : '',
            ];
        }

        return $rooms;
    }
}

if (!function_exists('getStatusRoom')) {
    function getStatusRoom()
    {
        foreach (\App\Models\Enums\RoomStatusEnum::cases() as $key => $data) {
            $status[$key] = [
                'value' => $data->value,
                'name' => $data->label(),
            ];
        }

        return $status;
    }
}
