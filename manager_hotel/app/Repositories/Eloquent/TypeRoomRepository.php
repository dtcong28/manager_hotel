<?php

namespace App\Repositories\Eloquent;

use App\Models\TypeRoom;

class TypeRoomRepository extends CustomRepository
{
    protected $model = TypeRoom::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function getSearchTypeRoom($params){
        $query = $this->select()->where('name', 'LIKE', '%' . $params . '%')->orderBy('id','desc');

        return $query->paginate(getConfig('page_number'));
    }
}
