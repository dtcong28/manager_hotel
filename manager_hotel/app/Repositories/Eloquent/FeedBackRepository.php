<?php

namespace App\Repositories\Eloquent;

use App\Models\FeedBack;

class FeedBackRepository extends CustomRepository
{
    protected $model = FeedBack::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function getSearchFeedBack($params){
        $query = $this->select('customers.name as name', 'feedback.*')
            ->leftJoin('customers', 'customers.id', 'feedback.customer_id')
            ->where('name', 'LIKE', '%' . $params . '%')
            ->orWhere('subject', 'LIKE', '%' . $params . '%')
            ->orWhere('content', 'LIKE', '%' . $params . '%')
            ->orWhere('star_rate', 'LIKE', '%' . $params . '%')
            ->orderBy('id', 'desc');

        return $query->paginate(getConfig('page_number'));
    }

    public function getNewsFeedBack(){
        return $this->orderBy('id', 'desc')->with('customer')->paginate(5);
    }
}
