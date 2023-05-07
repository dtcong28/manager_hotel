<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Support\Facades\Session;

class UserRepository extends CustomRepository
{
    protected $model = User::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function getSearchEmployee($params){
        $query = $this->select()
            ->where('name', 'LIKE', '%' . $params . '%')
            ->orWhere('email', 'LIKE', '%' . $params . '%')
            ->orderBy('id','desc');
//        dd($query->toSql(), $query->getBindings());
        return $query->paginate(getConfig('page_number'));
    }
}
