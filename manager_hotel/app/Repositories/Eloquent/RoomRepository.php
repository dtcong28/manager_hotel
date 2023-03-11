<?php

namespace App\Repositories\Eloquent;

use App\Models\Room;
use Illuminate\Support\Facades\Session;

class RoomRepository extends CustomRepository
{
    protected $model = Room::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function getListFilterRoom($params)
    {
        $data['sort'] = empty($params['sort']) ? 'id' : $params['sort'];
        $data['direction'] = empty($params['direction']) ? 'desc' : $params['direction'];
        $data['status_eq'] = \App\Models\Enums\RoomStatusEnum::VACANT->value;

        foreach ($params as $key=>$param)
        {
            $data['number_people_eq'] = $param;
            $query[$key] = $this->search($data)->get()->toArray();
        }

        return $query;
    }

    public function getDetailRoom($id)
    {
        $data['sort'] = empty($params['sort']) ? 'id' : $params['sort'];
        $data['direction'] = empty($params['direction']) ? 'desc' : $params['direction'];
        $data['id_eq'] = $id;

        return $this->search($data)->first()->toArray();
    }
}
