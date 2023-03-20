<?php

namespace App\Repositories\Eloquent;

use App\Models\Food;

class FoodRepository extends CustomRepository
{
    protected $model = Food::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function getListSelectFood($params)
    {

        $data['sort'] = empty($params['sort']) ? 'id' : $params['sort'];
        $data['direction'] = empty($params['direction']) ? 'desc' : $params['direction'];

        $i = 0;
        foreach ($params as $key=>$param)
        {
            $data['id_eq'] = $key;
            $query[$i] = $this->search($data)->first()->toArray();
            $i++;
        }

        return $query;
    }
}
