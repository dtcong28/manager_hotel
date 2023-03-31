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

    public function getListRoomByPeople($numberPeople)
    {
        $data['sort'] = 'id';
        $data['direction'] = 'desc';
        $results = [];

        foreach ($numberPeople as $key => $param) {
            $data['number_people_eq'] = $param;
            foreach ($this->search($data)->with(['typeRoom'])->get() as $index=>$item) {
                $item->image = $item->getMedia('images')[0]->getUrl();
                $results[$key][$index] = $item;
            }
        }

        // array_values is re-index
        return array_values($results);
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
            ->orderBy('id', 'desc');

        return $query->with(['typeRoom'])->paginate(getConfig('page_number'));
    }
}
