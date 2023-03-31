<?php

namespace App\Repositories\Eloquent;

use App\Models\Employee;

class EmployeeRepository extends CustomRepository
{
    protected $model = Employee::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function getSearchEmployee($params){
        $query = $this->select()
            ->where('name', 'LIKE', '%' . $params . '%')
            ->orWhere('email', 'LIKE', '%' . $params . '%')
            ->orWhere('phone', 'LIKE', '%' . $params . '%')
            ->orderBy('id','desc');

        return $query->paginate(getConfig('page_number'));
    }
}
