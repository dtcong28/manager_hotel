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
        $data['number_people_gteq'] = $params;
        $data['status_eq'] = \App\Models\Enums\RoomStatusEnum::VACANT->value;

        $query = $this->search($data);

        return $query->get();
    }
}
