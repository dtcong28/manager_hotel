<?php

namespace App\Repositories\Eloquent;

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

    public function getListFilterRoom($numberPeople, $checkIn, $checkOut)
    {
        $data['sort'] = 'id';
        $data['direction'] = 'desc';

        foreach ($numberPeople as $key => $param) {
            $data['number_people_eq'] = $param;
            $results[$key] = $this->search($data)
                ->where(function ($query) use ($checkIn) {
                    $query->where('status', '=', RoomStatusEnum::VACANT->value)
                        ->orWhere(function ($q) use ($checkIn) {
                            $q->where('status', '=', RoomStatusEnum::OCCUPIED->value)
                                ->where('time_check_out', '<=', $checkIn);
                        });
                })
                ->get()->toArray();
        }

        return $results;
    }

    public function getDetailRoom($id)
    {
        $data['sort'] = empty($params['sort']) ? 'id' : $params['sort'];
        $data['direction'] = empty($params['direction']) ? 'desc' : $params['direction'];
        $data['id_eq'] = $id;

        return $this->search($data)->first()->toArray();
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
}
