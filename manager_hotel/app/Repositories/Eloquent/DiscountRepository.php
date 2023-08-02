<?php

namespace App\Repositories\Eloquent;

use App\Models\Discount;
use Illuminate\Support\Facades\Session;

class DiscountRepository extends CustomRepository
{
    protected $model = Discount::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAvailableDiscount($params)
    {
        $params['sort'] = empty($params['sort']) ? 'id' : $params['sort'];
        $params['direction'] = empty($params['direction']) ? 'desc' : $params['direction'];

        return $this->search($params)->get();
    }

    public function findDiscount($params)
    {
        $params['sort'] = empty($params['sort']) ? 'id' : $params['sort'];
        $params['direction'] = empty($params['direction']) ? 'desc' : $params['direction'];

        return $this->search($params)->first();
    }

}
