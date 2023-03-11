<?php

namespace App\Services;

use App\Repositories\Eloquent\RestaurantRepository;
use Illuminate\Support\Facades\Hash;

class RestaurantService extends CustomService
{
    public function __construct()
    {
        parent::__construct();
        $this->setRepository(app(RestaurantRepository::class));
    }

    public function store($params)
    {
        return parent::store($params);
    }

    public function update($id, $params)
    {
        return parent::update($id, $params);
    }

    public function destroy($id)
    {
        return parent::destroy($id);
    }

//    protected function prepareBeforeStore(&$data)
//    {
//
//    }
//
//    protected function prepareBeforeUpdate(&$data)
//    {
//
//    }
}
